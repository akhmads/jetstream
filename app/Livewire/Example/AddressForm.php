<?php

namespace App\Livewire\Example;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Example;
use App\Models\Address;


class AddressForm extends Component
{
    public $set_id;
    public $address;
    public $city;
    public $province;
    public $addressModal = false;

    public function render()
    {
        return view('livewire.example.address-form');
    }

    public function mount(Request $request)
    {
        $example = Address::Find($request->id);
        $this->set_id = $example->id ?? '';
        $this->address = $example->address ?? '';
        $this->city = $example->city ?? '';
        $this->province = $example->province ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'address' => 'required',
                'city' => 'required',
                'province' => 'required',
            ]);

            Address::create($valid);
            session()->flash('success', __('Address saved'));

        }
        else
        {
            $valid = $this->validate([
                'address' => 'required',
                'city' => 'required',
                'province' => 'required',
            ]);

            $address = Address::find($this->set_id);
            $address->update($valid);
            session()->flash('success', __('Address saved'));
        }
    }
}
