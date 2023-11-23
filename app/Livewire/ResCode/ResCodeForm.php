<?php

namespace App\Livewire\ResCode;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\ResCode;

class ResCodeForm extends Component
{
    public $set_id;
    public $name = '';
    public $status = '';

    public function render()
    {
        return view('livewire.rescode.rescode-form');
    }

    public function mount(Request $request)
    {
        $rescode = ResCode::Find($request->id);
        $this->set_id = $rescode->id ?? '';
        $this->name = $rescode->name ?? '';
        $this->status = $rescode->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'status' => 'required',
            ]);

            $rescode = ResCode::create($valid);
            session()->flash('success', __('ResCode saved'));
            return redirect()->route('master.rescode.form',$rescode->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'status' => 'required',
            ]);
            $rescode = ResCode::find($this->set_id);
            $rescode->update($valid);
            session()->flash('success', __('ResCode saved'));
        }
    }
}
