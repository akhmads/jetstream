<?php

namespace App\Livewire\GL;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Code;
use App\Models\GLhd;
use App\Models\GLdt;

class GLForm extends Component
{
    public $set_id;
    public $code = '';
    public $date = '';
    public $note = '';
    public $debit_total = 0;
    public $credit_total = 0;
    public $tmp = [];

    public function render()
    {
        return view('livewire.gl.gl-form');
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

        $GLdt = GLdt::where('code',$this->code)->orderBy('id')->get();
        foreach($GLdt as $dt){
            $this->tmp[] = [
                'coa_code' => $dt->coa_code,
                'description' => $dt->description,
                'dc' => $dt->dc,
                'debit' => $dt->debit,
                'credit' => $dt->credit,
                'amount' => $dt->amount,
            ];
        }
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'date' => 'required',
                'note' => 'required',
                'tmp' => 'required|array|min:1',
                'tmp.*.description' => 'required',
                'tmp.*.coa_code' => 'required|distinct',
                'tmp.*.dc' => 'required',
                'tmp.*.debit' => '',
                'tmp.*.credit' => '',
            ]);

            $code = $this->autocode();
            $glhd = GLhd::create([
                'code' => $code,
                'date' => $this->date,
                'note' => $this->note,
                'debit_total' => $this->debit_total,
                'credit_total' => $this->credit_total,
            ]);

            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    GLdt::create([
                        'code' => $code,
                        'description' => $tm['description'],
                        'coa_code' => $tm['coa_code'],
                        'dc' => $tm['dc'],
                        'debit' => $tm['debit'],
                        'credit' => $tm['credit'],
                        'amount' => $tm['amount'],
                    ]);
                }
            }

            session()->flash('success', __('Saved'));
            return redirect()->route('gl.form',$glhd->id);
        }
        else
        {
            $valid = $this->validate([
                'date' => 'required',
                'note' => 'required',
                'credit_total' => 'same:debit_total',
                'tmp' => 'required|array|min:1',
                'tmp.*.description' => 'required',
                'tmp.*.coa_code' => 'required|distinct',
                'tmp.*.dc' => 'required',
                'tmp.*.debit' => '',
                'tmp.*.credit' => '',
            ]);
            $glhd = GLhd::find($this->set_id);
            $glhd->update([
                'date' => $this->date,
                'note' => $this->note,
                'debit_total' => $this->debit_total,
                'credit_total' => $this->credit_total,
            ]);

            $detail = GLdt::where('code',$this->code);
            $detail->delete();
            if( count($this->tmp) > 0 ) {
                foreach($this->tmp as $tm)
                {
                    $detail->create([
                        'code' => $this->code,
                        'description' => $tm['description'],
                        'coa_code' => $tm['coa_code'],
                        'dc' => $tm['dc'],
                        'debit' => $tm['debit'],
                        'credit' => $tm['credit'],
                        'amount' => $tm['amount'],
                    ]);
                }
            }

            session()->flash('success', __('Saved'));
        }
    }

    protected function autocode(): string
    {
        $time = strtotime($this->date);
        $prefix = 'JV/'.date('y',$time).'/'.date('m',$time).'/';
        Code::updateOrCreate(
            ['prefix' => $prefix],
            ['num' => DB::raw('num+1')]
        );
        $code = Code::where('prefix', $prefix)->first();
        return $code->prefix . Str::padLeft($code->num, 4, '0');
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
        $this->dispatch('detail-change');
    }

    public function removeDetail($index): Void
    {
        unset($this->tmp[$index]);
        $this->dispatch('detail-change');
    }

    public function updatedTmp($value,$key): Void
    {
        $parts = explode('.',$key);
        $index = $parts[0] ?? '';
        $this->sum($index);
    }

    public function sum($index): Void
    {
        if( $index == "" ) return;

        // $dc = $this->tmp[$index]['dc'];
        // $debit = $this->tmp[$index]['debit'];
        // $credit = $this->tmp[$index]['credit'];
        // if( $dc == 'D' ){
        //     $this->tmp[$index]['amount'] = $debit * -1;
        // }
        // if( $dc == 'C' ){
        //     $this->tmp[$index]['amount'] = $credit * -1;
        // }

        $debit_total = $credit_total = 0;
        foreach($this->tmp as $tmp)
        {
            $debit_total = $debit_total + $tmp['debit'];
            $credit_total = $credit_total + $tmp['credit'];
        }

        $this->debit_total = $debit_total;
        $this->credit_total = $credit_total;
    }
}
