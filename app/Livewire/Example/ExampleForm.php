<?php

namespace App\Livewire\Example;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Example;

class ExampleForm extends Component
{
    public $set_id;
    public $name;
    public $gender;
    public $birth_date;
    public $address;

    public function render()
    {
        return view('livewire.example.example-form');
    }

    public function mount(Request $request)
    {
        $example = Example::Find($request->id);
        $this->set_id = $example->id ?? '';
        $this->name = $example->name ?? '';
        $this->gender = $example->gender ?? '';
        $this->birth_date = isset($example->birth_date) ? ($example->birth_date)->format('Y-m-d') : '';
        $this->address = $example->address ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'address' => 'required',
            ]);

            $example = Example::create($valid);
            session()->flash('success', __('Example saved'));
            return redirect()->route('example.form',$example->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'address' => 'required',
            ]);
            $example = Example::find($this->set_id);
            $example->update($valid);
            session()->flash('success', __('Example saved'));
        }
    }
}
