<?php

namespace App\Livewire\Journal;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Hyco\Cast;
use App\Models\Code;
use App\Models\GLhd;
use App\Models\GLdt;
use Closure;

class Form extends Component
{
    public $set_id;
    public $code = '';
    public $date = '';
    public $note = '';
    public $contact_id = '';
    public $debit_total = 0;
    public $credit_total = 0;
    public $ref_name = '';
    public $ref_id = '';
    public $tmp = [];

    public function render()
    {
        return view('livewire.journal.form');
    }

    public function mount(Request $request)
    {
        $gl = GLhd::Find($request->id);
        $this->set_id = $gl->id ?? '';
        $this->code = $gl->code ?? '';
        $this->date = isset($gl->date) ? ($gl->date)->format('Y-m-d') : '';
        $this->note = $gl->note ?? '';
        $this->debit_total = $gl->debit_total ?? '0';
        $this->credit_total = $gl->credit_total ?? '0';
        $this->contact_id = $gl->contact_id ?? '0';
        $this->ref_name = $gl->ref_name ?? '';
        $this->ref_id = $gl->ref_id ?? '';

        $GLdt = GLdt::where('code',$this->code)->orderBy('id')->get();
        foreach($GLdt as $dt){
            $this->tmp[] = [
                'coa_code' => $dt->coa_code,
                'description' => $dt->description,
                'dc' => $dt->dc,
                'amount' => Cast::currency(abs($dt->amount)),
                'debit' => $dt->debit,
                'credit' => $dt->credit,
            ];
        }
    }

    public function store()
    {
        $this->sum();

        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'date' => 'required',
                'note' => 'required',
                'credit_total' => function (string $attribute, mixed $value, Closure $fail) {
                    if (floatval($this->debit_total) != floatval($this->credit_total)) {
                        $fail(_("Total debt and credit must be the same"));
                    }
                },
                'tmp' => 'required|array|min:1',
                'tmp.*.description' => 'required',
                'tmp.*.coa_code' => 'required|distinct',
                'tmp.*.dc' => 'required',
                'tmp.*.amount' => 'required|min:1|gt:1',
            ]);

            $code = $this->autocode();

            $debit_total = $credit_total = 0;
            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    GLdt::create([
                        'code' => $code,
                        'description' => $tm['description'],
                        'coa_code' => $tm['coa_code'],
                        'dc' => $tm['dc'],
                        'debit' => $tm['dc']=='D' ? $tm['amount'] : 0,
                        'credit' => $tm['dc']=='C' ? $tm['amount'] : 0,
                        'amount' => $tm['amount'],
                    ]);
                    if( $tm['dc'] == 'D' ) $debit_total = $debit_total + $tm['amount'];
                    if( $tm['dc'] == 'C' ) $credit_total = $credit_total + $tm['amount'];
                }
            }

            $glhd = GLhd::create([
                'code' => $code,
                'date' => $this->date,
                'note' => $this->note,
                'debit_total' => $debit_total,
                'credit_total' => $credit_total,
                'contact_id' => $this->contact_id,
                'ref_name' => 'journal',
                'ref_id' => $code,
            ]);

            session()->flash('success', __('Saved'));
            return redirect()->route('finance.journal.form',$glhd->id);
        }
        else
        {
            $valid = $this->validate([
                'date' => 'required',
                'note' => 'required',
                'credit_total' => function (string $attribute, mixed $value, Closure $fail) {
                    if (floatval($this->debit_total) != floatval($this->credit_total)) {
                        $fail(_("Total debt and credit must be the same"));
                    }
                },
                'tmp' => 'required|array|min:1',
                'tmp.*.description' => 'required',
                'tmp.*.coa_code' => 'required|distinct',
                'tmp.*.dc' => 'required',
                'tmp.*.amount' => 'required|min:1|gt:0',
            ]);

            $detail = GLdt::where('code',$this->code);
            $detail->delete();
            $debit_total = $credit_total = 0;
            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    $detail->create([
                        'code' => $this->code,
                        'description' => $tm['description'],
                        'coa_code' => $tm['coa_code'],
                        'dc' => $tm['dc'],
                        'debit' => $tm['dc']=='D' ? $tm['amount'] : 0,
                        'credit' => $tm['dc']=='C' ? $tm['amount'] : 0,
                        'amount' => $tm['amount'],
                    ]);

                    if( $tm['dc'] == 'D' ) $debit_total = $debit_total + $tm['amount'];
                    if( $tm['dc'] == 'C' ) $credit_total = $credit_total + $tm['amount'];
                }
            }

            $glhd = GLhd::find($this->set_id);
            $glhd->update([
                'date' => $this->date,
                'note' => $this->note,
                'debit_total' => $debit_total,
                'credit_total' => $credit_total,
                'contact_id' => $this->contact_id,
            ]);

            session()->flash('success', __('Saved'));
            return redirect()->route('finance.journal.form',$this->set_id);
        }
    }

    protected function autocode(): string
    {
        return \App\Hyco\Code::auto( $this->date, 'Journal Voucher' );
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
            'description' => '',
            'dc' => 'D',
            'debit' => '0',
            'credit' => '0',
            'amount' => '0',
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
        $debit_total = $credit_total = 0;
        foreach($this->tmp as $tm)
        {
            if( $tm['dc'] == 'D' ) $debit_total = $debit_total + $tm['amount'];
            if( $tm['dc'] == 'C' ) $credit_total = $credit_total + $tm['amount'];
        }

        $this->debit_total = $debit_total;
        $this->credit_total = $credit_total;
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
