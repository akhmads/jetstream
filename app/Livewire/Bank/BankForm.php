<?php

namespace App\Livewire\Bank;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Bank;

class BankForm extends Component
{
    public $set_id;
    public $name = '';
    public $status = '';

    public function render()
    {
        return view('livewire.bank.bank-form');
    }

    public function mount(Request $request)
    {
        $bank = Bank::Find($request->id);
        $this->set_id = $bank->id ?? '';
        $this->name = $bank->name ?? '';
        $this->status = $bank->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'status' => 'required',
            ]);

            $bank = Bank::create($valid);
            session()->flash('success', __('Bank saved'));
            return redirect()->route('master.bank.form',$bank->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'status' => 'required',
            ]);
            $bank = Bank::find($this->set_id);
            $bank->update($valid);
            session()->flash('success', __('Bank saved'));
        }
    }
}
