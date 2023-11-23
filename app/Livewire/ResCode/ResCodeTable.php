<?php

namespace App\Livewire\ResCode;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ResCode;

class ResCodeTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "resource";
    public $sortDir = "asc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $confirmDeletion = false;
    public $set_id;

    public function render()
    {
        $ResCode = ResCode::orderby($this->sortColumn,$this->sortDir)->select('*');
        if(!empty($this->searchKeyword)){
            $ResCode->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $ResCode = $ResCode->paginate($this->perPage);

        return view('livewire.res-code.res-code-table',['data' => $ResCode]);
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

        ResCode::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Resource code has been deleted'));
    }
}
