<?php

namespace App\Livewire\Salesman;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Salesman;
use App\Models\Code;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SalesmanForm extends Component
{
    public $set_id;
    public $salesman_code = '';
    public $name = '';
	public $status = '';

    public function render()
    {
        return view('livewire.salesman.salesman-form');
    }

    public function mount(Request $request)
    {
        $salesman = Salesman::Find($request->id);
        $this->set_id = $salesman->id ?? '';
        $this->salesman_code = $salesman->salesman_code ?? '';
        $this->name = $salesman->name ?? '';
		$this->status = $salesman->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'salesman_code' => 'required',
                'name' => 'required',
                'status' => 'required',
            ]);

        

            $salesman = Salesman::create([
            'salesman_code' => $this->salesman_code,
			'name' => $this->name,
			'status' => $this->status,
			
			]);
            session()->flash('success', __('Sales saved'));
            return redirect()->route('salesman.form',$salesman->id);
        }
        else
        {
            $valid = $this->validate([
                'salesman_code' => 'required',
                'name' => 'required',
                'status' => 'required',
            ]);
            $salesman = Salesman::find($this->set_id);
            $salesman->update([
			'salesman_code' => $this->salesman_code,
            'name' => $this->name,
			'status' => $this->status,
			
			]);
            session()->flash('success', __('Salesman saved'));
        }
    }

}
