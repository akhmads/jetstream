<?php

namespace App\Livewire\Item;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Item;

class ItemTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "id";
    public $sortDir = "desc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $confirmDeletion = false;
    public $set_id;

    public function render()
    {
        $item = Item::orderby($this->sortColumn,$this->sortDir)->select('*')
            ->with('coabuying')->with('coaselling')->with('coacogs');
        if(!empty($this->searchKeyword)){
            $keyword = strtoupper($this->searchKeyword);
            $item->where(DB::raw('UPPER(name)'),'like',"%".$keyword."%");
        }
        $items = $item->paginate($this->perPage);

        return view('livewire.item.item-table',['items' => $items]);
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function sortOrder($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDir = ($this->sortDir == 'asc') ? 'desc' : 'asc';
        $this->sortLink = [];
        $this->sortLink[$columnName] = $this->sortDir;
    }

    public function delete($id)
    {
        $this->confirmDeletion = true;
        $this->set_id = $id;
    }

    public function destroy()
    {

        Item::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Item has been deleted'));
        return redirect()->route('item');
    }
}
