<?php

namespace App\Livewire\Item;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemForm extends Component
{
    public $set_id;
    public $name = '';

    public function render()
    {
        return view('livewire.item.item-form');
    }

    public function mount(Request $request)
    {
        $item = Item::Find($request->id);
        $this->set_id = $item->id ?? '';
        $this->name = $item->name ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
            ]);

            $item = Item::create($valid);
            session()->flash('success', __('Item saved'));
            return redirect()->route('item.form',$item->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
            ]);
            $item = Item::find($this->set_id);
            $item->update($valid);
            session()->flash('success', __('Item saved'));
        }
    }
}
