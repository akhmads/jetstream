<?php

namespace App\Livewire\BankAccount;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\BankAccount;

class BankAccountForm extends Component
{
    public $set_id;
    public $number = '';
    public $bank_id = '';
    public $coa_code = '';
    public $status = '';

    public function render()
    {
        return view('livewire.bank-account.bank-account-form');
    }

    public function mount(Request $request)
    {
        $BankAccount = BankAccount::Find($request->id);
        $this->set_id   = $BankAccount->id ?? '';
        $this->number   = $BankAccount->number ?? '';
        $this->bank_id  = $BankAccount->bank_id ?? '';
        $this->coa_code = $BankAccount->coa_code ?? '';
        $this->status   = $BankAccount->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'number' => 'required',
                'bank_id' => 'required',
                'status' => 'required',
                'coa_code' => 'required',
            ]);

            $valid['currency'] = 'IDR';
            $BankAccount = BankAccount::create($valid);
            session()->flash('success', __('Bank account saved'));
            return redirect()->route('master.bank-account.form',$BankAccount->id);
        }
        else
        {
            $valid = $this->validate([
                'number' => 'required',
                'bank_id' => 'required',
                'status' => 'required',
                'coa_code' => 'required',
            ]);

            $valid['currency'] = 'IDR';
            $BankAccount = BankAccount::find($this->set_id);
            $BankAccount->update($valid);
            session()->flash('success', __('Bank account saved'));
        }
    }
}
