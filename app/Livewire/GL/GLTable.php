<?php

namespace App\Livewire\GL;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GLhd;
use App\Models\GLdt;

class GLTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "date";
    public $sortDir = "desc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $confirmDeletion = false;
    public $set_id;

    public function render()
    {
        $GL = GLhd::orderby($this->sortColumn,$this->sortDir)->select('*');
        if(!empty($this->searchKeyword)){
            $GL->orWhere('code','like',"%".$this->searchKeyword."%");
        }
        $GL = $GL->paginate($this->perPage);

        return view('livewire.gl.gl-table',['GL' => $GL]);
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

        Coa::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('GL has been deleted'));
    }
}
