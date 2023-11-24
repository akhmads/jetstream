<?php

namespace App\Livewire\CashTransIn;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Hyco\AutoJournal;
use App\Hyco\Cast;
use App\Models\CashTrans;
use App\Models\CashTransDetail;
use App\Models\Code;
use App\Models\GLhd;
use App\Models\GLdt;
use Closure;

class CashTransInForm extends Component
{
    public $set_id;
    public $number = '';
    public $ref_number = '';
    public $date = '';
    public $contact_id = '';
    public $cash_account_id = '';
    public $amount = 0;
    public $note = '';
    public $type = '';
    public $status = '';
    public $total = 0;
    public $tmp = [];

    public function render()
    {
        return view('livewire.cash-trans-in.cash-trans-in-form');
    }

    public function mount(Request $request)
    {
        $CashTrans = CashTrans::Find($request->id);
        $this->set_id       = $CashTrans->id ?? '';
        $this->number       = $CashTrans->number ?? '';
        $this->ref_number   = $CashTrans->ref_number ?? '';
        $this->date         = isset($CashTrans->date) ? ($CashTrans->date)->format('Y-m-d') : '';
        $this->contact_id   = $CashTrans->contact_id ?? '';
        $this->cash_account_id = $CashTrans->cash_account_id ?? '';
        $this->amount       = $CashTrans->amount ?? 0;
        $this->note         = $CashTrans->note ?? '';
        $this->type         = $CashTrans->type ?? '';
        $this->status       = $CashTrans->status ?? '';
        $this->total        = $CashTrans->amount ?? 0;
        $CashTransDetail    = $CashTrans->detail ?? [];

        foreach($CashTransDetail as $dt){
            $this->tmp[] = [
                'number' => $dt->number,
                'coa_code' => $dt->coa_code,
                'amount' => $dt->amount,
                'currency' => $dt->currency,
                'rate' => $dt->rate,
                'hamount' => $dt->hamount,
                'note' => $dt->note,
            ];
        }
    }

    public function store()
    {
        $this->sum();

        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'ref_number' => 'required',
                'date' => 'required',
                'contact_id' => 'required',
                'cash_account_id' => 'required',
                'note' => 'required',
                'tmp' => 'required|array|min:1',
                'tmp.*.coa_code' => 'required|distinct',
                'tmp.*.amount' => 'required|min:1|gt:1',
                'tmp.*.currency' => 'required',
                'tmp.*.rate' => 'required|min:1',
                'tmp.*.note' => 'required',
            ]);

            $number = $this->autocode();

            $total = 0;
            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    CashTransDetail::create([
                        'number' => $number,
                        'coa_code' => $tm['coa_code'],
                        'amount' => $tm['amount'],
                        'currency' => $tm['currency'],
                        'rate' => $tm['rate'],
                        'hamount' => $tm['hamount'],
                        'note' => $tm['note'],
                    ]);
                    $total = $total + $tm['hamount'];
                }
            }

            $CashTrans = CashTrans::create([
                'number' => $number,
                'ref_number' => $this->ref_number,
                'contact_id' => $this->contact_id,
                'cash_account_id' => $this->cash_account_id,
                'amount' => $total,
                'date' => $this->date,
                'note' => $this->note,
            ]);

            session()->flash('success', __('Saved'));
            return redirect()->route('cash_bank.cash-in.form',$CashTrans->id);
        }
        else
        {
            $valid = $this->validate([
                'ref_number' => 'required',
                'date' => 'required',
                'contact_id' => 'required',
                'cash_account_id' => 'required',
                'amount' => 'required',
                'note' => 'required',
                'tmp' => 'required|array|min:1',
                'tmp.*.coa_code' => 'required|distinct',
                'tmp.*.amount' => 'required|min:1|gt:1',
                'tmp.*.currency' => 'required',
                'tmp.*.rate' => 'required|min:1',
                'tmp.*.note' => 'required',
            ]);

            $CashTransDetail = CashTransDetail::where('number',$this->number);
            $CashTransDetail->delete();
            $total = 0;
            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    $CashTransDetail->create([
                        'number' => $this->number,
                        'coa_code' => $tm['coa_code'],
                        'amount' => $tm['amount'],
                        'currency' => $tm['currency'],
                        'rate' => $tm['rate'],
                        'hamount' => $tm['hamount'],
                        'note' => $tm['note'],
                    ]);
                    $total = $total + $tm['hamount'];
                }
            }

            $CashTrans = CashTrans::find($this->set_id);
            $CashTrans->update([
                'ref_number' => $this->ref_number,
                'contact_id' => $this->contact_id,
                'cash_account_id' => $this->cash_account_id,
                'amount' => $total,
                'date' => $this->date,
                'note' => $this->note,
            ]);

            // ---------------------------------------
            // Start Auto Journal
            // ---------------------------------------

            AutoJournal::reset($this->number, 'Cash In');
            $JournalCode = \App\Hyco\Code::auto($this->date,'Journal Voucher');
            GLhd::create([
                'code' => $JournalCode,
                'date' => $this->date,
                'note' => $this->note,
                'debit_total' => $total,
                'credit_total' => $total,
                'contact_id' => $this->contact_id,
                'ref_name' => 'Cash In',
                'ref_id' => $this->number,
            ]);
            GLdt::create([
                'code' => $JournalCode,
                'description' => $this->note,
                'coa_code' => $CashTrans->account->coa->code ?? '',
                'dc' => 'D',
                'debit' => $total,
                'credit' => 0,
                'amount' => $total,
            ]);
            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    GLdt::create([
                        'code' => $JournalCode,
                        'description' => $tm['note'],
                        'coa_code' => $tm['coa_code'],
                        'dc' => 'C',
                        'debit' => 0,
                        'credit' => $tm['hamount'],
                        'amount' => $tm['hamount'] * -1,
                    ]);
                }
            }
            // ---------------------------------------
            // End Auto Journal
            // ---------------------------------------

            session()->flash('success', __('Saved'));
            return redirect()->route('cash_bank.cash-in.form',$this->set_id);
        }
    }

    protected function autocode(): string
    {
        $time = strtotime($this->date);
        $prefix = 'BKM/'.date('y',$time).'/'.date('m',$time).'/';
        Code::updateOrCreate(
            ['prefix' => $prefix],
            ['num' => DB::raw('num+1')]
        );
        $code = Code::where('prefix', $prefix)->first();
        return $code->prefix . Str::padLeft($code->num, 4, '0');
    }

    #[On('set-contact')]
    public function setContactId( $id )
    {
        $this->contact_id = $id;
    }

    public function addDetail(): Void
    {
        $this->tmp[] = [
            'coa_code' => '',
            'amount' => Cast::currency(0),
            'currency' => 'IDR',
            'rate' => Cast::currency(1),
            'hamount' => Cast::currency(0),
            'note' => '',
        ];
    }

    public function removeDetail($index): Void
    {
        unset($this->tmp[$index]);
    }

    public function updatedTmp($value,$key): Void
    {
        // $parts = explode('.',$key);
        // $index = $parts[0] ?? '';
        // $this->sum($index);
    }

    public function sum(): Void
    {
        $total = 0;
        foreach($this->tmp as $index=>$tm)
        {
            $tm['hamount'] = Cast::number($tm['rate']) * Cast::number($tm['amount']);
            $total = $total + $tm['hamount'];
            $this->tmp[$index]['hamount'] = $tm['hamount'];
        }
        $this->total = $total;
    }

    #[On('set-coa')]
    public function setCoa( $id, $index )
    {
        if(isset($this->tmp[$index]))
        {
            $this->tmp[$index]['coa_code'] = $id;
        }
    }
}
