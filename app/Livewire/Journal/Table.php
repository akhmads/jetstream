<?php

namespace App\Livewire\Journal;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GLhd;
use App\Models\GLdt;

class Table extends Component
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
        $GL = GLhd::orderby($this->sortColumn,$this->sortDir);
        if(!empty($this->searchKeyword)){
            $GL->orWhere('glhd.code','like',"%".$this->searchKeyword."%");
        }
        $data = $GL->paginate($this->perPage);

        return view('livewire.journal.table',['data' => $data]);
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
        $hd = GLhd::where('id',$this->set_id)->orderBy('id')->first();
        $dt = GLdt::where('code',$hd->code);
        $dt->delete();
        $hd->delete();

        $this->confirmDeletion = false;
        session()->flash('success', __('Data has been deleted'));
    }
}
