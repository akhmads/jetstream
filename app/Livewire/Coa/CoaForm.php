<?php

namespace App\Livewire\Coa;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Coa;

class CoaForm extends Component
{
    public $set_id;
    public $code = '';
    public $name = '';
    public $normal_balance = '';
    public $report_type = '';
    public $report_operator = '';
    public $status = '';

    public function render()
    {
        return view('livewire.coa.coa-form');
    }

    public function mount(Request $request)
    {
        $coa = Coa::Find($request->id);
        $this->set_id = $coa->id ?? '';
        $this->code = $coa->code ?? '';
        $this->name = $coa->name ?? '';
        $this->normal_balance = $coa->normal_balance ?? '';
        $this->report_type = $coa->report_type ?? '';
        $this->report_operator = $coa->report_operator ?? '';
        $this->status = $coa->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'code' => 'required|unique:coa,code',
                'name' => 'required',
                'normal_balance' => 'required',
                'report_type' => 'required',
                'report_operator' => 'required',
                'status' => 'required',
            ]);

            $coa = Coa::create($valid);
            session()->flash('success', __('Coa saved'));
            return redirect()->route('coa.form',$coa->id);
        }
        else
        {
            $valid = $this->validate([
                'code' => 'required|unique:coa,code,'.$this->set_id,
                'name' => 'required',
                'normal_balance' => 'required',
                'report_type' => 'required',
                'report_operator' => 'required',
                'status' => 'required',
            ]);
            $coa = Coa::find($this->set_id);
            $coa->update($valid);
            session()->flash('success', __('Coa saved'));
        }
    }
}
