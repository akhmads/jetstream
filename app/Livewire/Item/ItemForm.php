<?php

namespace App\Livewire\Item;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemForm extends Component
{
    public $set_id;
    public $item_code = '';
    public $type = '';
    public $name = '';
    public $item_group = '';
    public $coa_selling = '';
    public $coa_buying = '';
    public $coa_cogs = '';
    public $status = '';
    

    public function render()
    {
        return view('livewire.item.item-form');
    }

    public function mount(Request $request)
    {
        $item = Item::Find($request->id);
        $this->set_id = $item->id ?? '';
        $this->item_code = $item->item_code ?? '';
        $this->type = $item->type ?? '';
        $this->name = $item->name ?? '';
        $this->item_group = $item->item_group ?? '';
        $this->coa_selling = $item->coa_selling ?? '';
        $this->coa_buying = $item->coa_buying ?? '';
        $this->coa_cogs = $item->coa_cogs ?? '';
        $this->status = $item->status ?? '';

    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'item_code' => 'required',
                'type' => 'required',
                'name' => 'required',
                'item_group' => 'required',
                'coa_selling' => 'required',
                'coa_buying' => 'required',
                'coa_cogs' => '',
                'status' => 'required',
            ]);

            $item = Item::create($valid);
            session()->flash('success', __('Item saved'));
            return redirect()->route('item.form',$item->id);
        }
        else
        {
            $valid = $this->validate([
                'type' => 'required',
                'name' => 'required',
                'item_group' => 'required',
                'coa_selling' => 'required',
                'coa_buying' => 'required',
                'coa_cogs' => '',
                'status' => 'required',
            ]);
            $item = Item::find($this->set_id);
            $item->update($valid);
            session()->flash('success', __('Item saved'));
        }
    }
}
