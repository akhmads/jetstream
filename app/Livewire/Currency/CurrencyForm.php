<?php

namespace App\Livewire\Currency;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyForm extends Component
{
    public $set_id;
    public $code = '';
    public $name = '';
    public $status = '';

    public function render()
    {
        return view('livewire.currency.currency-form');
    }

    public function mount(Request $request)
    {
        $currency = Currency::Find($request->id);
        $this->set_id = $currency->id ?? '';
        $this->code = $currency->code ?? '';
        $this->name = $currency->name ?? '';
        $this->status = $currency->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'code' => 'required|size:3|unique:currency,code',
                'name' => 'required',
                'status' => 'required',
            ]);

            $currency = Currency::create($valid);
            session()->flash('success', __('Currency saved'));
            return redirect()->route('master.currency.form',$currency->id);
        }
        else
        {
            $valid = $this->validate([
                'code' => 'required|size:3|unique:currency,code,'.$this->set_id,
                'name' => 'required',
                'status' => 'required',
            ]);
            $currency = Currency::find($this->set_id);
            $currency->update($valid);
            session()->flash('success', __('Currency saved'));
        }
    }
}
