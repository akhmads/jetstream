<?php

namespace App\Livewire\CashAccount;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Cash;
use App\Models\CashAccount;

class CashAccountForm extends Component
{
    public $set_id;
    public $name = '';
    public $cash_id = '';
    public $coa_code = '';
    public $status = '';

    public function render()
    {
        return view('livewire.cash-account.cash-account-form');
    }

    public function mount(Request $request)
    {
        $CashAccount = CashAccount::Find($request->id);
        $this->set_id   = $CashAccount->id ?? '';
        $this->name   = $CashAccount->name ?? '';
        $this->coa_code = $CashAccount->coa_code ?? '';
        $this->status   = $CashAccount->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'status' => 'required',
                'coa_code' => 'required',
            ]);

            $valid['currency'] = 'IDR';
            $CashAccount = CashAccount::create($valid);
            session()->flash('success', __('Cash account saved'));
            return redirect()->route('master.cash-account.form',$CashAccount->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'status' => 'required',
                'coa_code' => 'required',
            ]);

            $valid['currency'] = 'IDR';
            $CashAccount = CashAccount::find($this->set_id);
            $CashAccount->update($valid);
            session()->flash('success', __('Cash account saved'));
        }
    }
}
