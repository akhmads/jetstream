<?php

namespace App\Livewire\CashTransIn;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Hyco\AutoJournal;
use App\Hyco\Cast;
use App\Hyco\Code;
use App\Models\CashTrans;
use App\Models\CashTransDetail;
use App\Models\GLhd;
use App\Models\GLdt;
use Closure;

class CashTransInForm extends Component
{
    public $set_id;
    public $code = '';
    public $ref_code = '';
    public $date = '';
    public $contact_id = '';
    public $cash_account_id = '';
    public $amount = 0;
    public $note = '';
    public $type = '';
    public $status = '';
    public $total = 0;
    public $data;
    public $tmp = [];
    public $open = true;
    public $showApproveButton = false;
    public $confirmApprove = false;

    public function render()
    {
        return view('livewire.cash-trans-in.cash-trans-in-form');
    }

    public function mount(Request $request)
    {
        $CashTrans = $this->data = CashTrans::Find($request->id);
        $this->set_id       = $CashTrans->id ?? '';
        $this->code         = $CashTrans->code ?? '';
        $this->ref_code     = $CashTrans->ref_code ?? '';
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
                'code' => $dt->code,
                'coa_code' => $dt->coa_code,
                'amount' => $dt->amount,
                'currency' => $dt->currency,
                'rate' => $dt->rate,
                'hamount' => $dt->hamount,
                'note' => $dt->note,
            ];
        }

        $this->initialDetail();

        if(in_array($this->status,['approve','void'])){
            $this->open = false;
        }
        if(!empty($this->set_id)){
            $this->showApproveButton = true;
        }
        if($this->status == 'approve'){
            $this->showApproveButton = false;
        }
    }

    public function store()
    {
        $this->sum();
        $this->castAmount();

        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'ref_code' => 'required',
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
            ],[],[
                'tmp.*.coa_code' => 'Coa (row :index)',
                'tmp.*.amount' => 'Amount (row :index)',
                'tmp.*.currency' => 'Currency (row :index)',
                'tmp.*.rate' => 'Rate (row :index)',
                'tmp.*.note' => 'Note (row :index)',
            ]);

            $code = Code::auto( $this->date, 'Cash In' );

            $total = 0;
            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    CashTransDetail::create([
                        'code' => $code,
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
                'type' => 'in',
                'status' => 'unapprove',
                'code' => $code,
                'ref_code' => $this->ref_code,
                'contact_id' => $this->contact_id,
                'cash_account_id' => $this->cash_account_id,
                'amount' => $total,
                'date' => $this->date,
                'note' => $this->note,
            ],[],[
                'tmp.*.coa_code' => 'Coa (row :index)',
                'tmp.*.amount' => 'Amount (row :index)',
                'tmp.*.currency' => 'Currency (row :index)',
                'tmp.*.rate' => 'Rate (row :index)',
                'tmp.*.note' => 'Note (row :index)',
            ]);

            session()->flash('success', __('Saved'));
            return redirect()->route('cash_bank.cash-in.form',$CashTrans->id);
        }
        else
        {
            $valid = $this->validate([
                'ref_code' => 'required',
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

            $CashTransDetail = CashTransDetail::where('code',$this->code);
            $CashTransDetail->delete();
            $total = 0;
            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    $CashTransDetail->create([
                        'code' => $this->code,
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
                'ref_code' => $this->ref_code,
                'contact_id' => $this->contact_id,
                'cash_account_id' => $this->cash_account_id,
                'amount' => $total,
                'date' => $this->date,
                'note' => $this->note,
            ]);

            session()->flash('success', __('Saved'));
            return redirect()->route('cash_bank.cash-in.form',$this->set_id);
        }
    }

    public function initialDetail()
    {
        if(empty($this->set_id) AND count($this->tmp)==0){
            $this->tmp[] = [
                'coa_code' => '',
                'amount' => Cast::currency(0),
                'currency' => 'IDR',
                'rate' => Cast::currency(1),
                'hamount' => Cast::currency(0),
                'note' => '',
            ];
        }
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

    public function castAmount(): Void
    {
        foreach($this->tmp as $index=>$tm)
        {
            $this->tmp[$index]['rate'] = Cast::number($tm['rate']);
            $this->tmp[$index]['amount'] = Cast::number($tm['amount']);
        }
    }

    #[On('set-coa')]
    public function setCoa( $id, $index )
    {
        if(isset($this->tmp[$index]))
        {
            $this->tmp[$index]['coa_code'] = $id;
        }
    }

    public function showApprove($id)
    {
        $this->confirmApprove = true;
        $this->set_id = $id;
    }

    public function approve()
    {
        $CashTrans = CashTrans::find($this->set_id);
        $CashTrans->status = 'approve';
        $CashTrans->save();

        // ---------------------------------------
        // Start Auto Journal
        // ---------------------------------------

        AutoJournal::reset($CashTrans->code, 'Cash In');
        $JournalCode = \App\Hyco\Code::auto($CashTrans->date,'Journal Voucher');
        GLhd::create([
            'code' => $JournalCode,
            'date' => $CashTrans->date,
            'note' => $CashTrans->note,
            'debit_total' => $CashTrans->amount,
            'credit_total' => $CashTrans->amount,
            'contact_id' => $CashTrans->contact_id,
            'ref_name' => 'Cash In',
            'ref_id' => $CashTrans->code,
            'lock' => '1',
        ]);
        GLdt::create([
            'code' => $JournalCode,
            'description' => $CashTrans->note,
            'coa_code' => $CashTrans->account->coa->code ?? '',
            'dc' => 'D',
            'debit' => $CashTrans->amount,
            'credit' => 0,
            'amount' => $CashTrans->amount,
        ]);
        if( count($CashTrans->detail) > 0 ) {
            foreach($CashTrans->detail as $detail)
            {
                GLdt::create([
                    'code' => $JournalCode,
                    'description' => $detail->note,
                    'coa_code' => $detail->coa_code,
                    'dc' => 'C',
                    'debit' => 0,
                    'credit' => $detail->hamount,
                    'amount' => $detail->hamount * -1,
                ]);
            }
        }
        // ---------------------------------------
        // End Auto Journal
        // ---------------------------------------

        session()->flash('success', __('Approved'));
        return redirect()->route('cash_bank.cash-in');
    }

    public function doVoid($id)
    {
        $CashTrans = CashTrans::find($id);
        $CashTrans->status = 'void';
        $CashTrans->save();

        session()->flash('success', __('Voided'));
    }
}
