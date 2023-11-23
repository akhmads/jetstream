<?php

namespace App\Livewire\ResCode;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\ResCode;

class ResCodeForm extends Component
{
    public $set_id;
    public $resource = '';
    public $code = '';

    public function render()
    {
        return view('livewire.res-code.res-code-form');
    }

    public function mount(Request $request)
    {
        $ResCode = ResCode::Find($request->id);
        $this->set_id = $ResCode->id ?? '';
        $this->resource = $ResCode->resource ?? '';
        $this->code = $ResCode->code ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'resource' => 'required',
                'code' => 'required',
            ]);

            $ResCode = ResCode::create([
                'code' => $this->code
            ]);
            session()->flash('success', __('Saved'));
            return redirect()->route('master.res-code.form',$ResCode->id);
        }
        else
        {
            $valid = $this->validate([
                'resource' => 'required',
                'code' => 'required',
            ]);
            $ResCode = ResCode::find($this->set_id);
            $ResCode->update([
                'code' => $this->code
            ]);
            session()->flash('success', __('Saved'));
        }
    }
}
