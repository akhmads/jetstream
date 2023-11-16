<?php

namespace App\Livewire\BeginningBalance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Coa;
use App\Models\GLhd;
use App\Models\GLdt;

class Table extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "code";
    public $sortDir = "asc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $coa_code = '';
    public $confirmDeletion = false;
    public $set_id;

    public function render()
    {
        $COA = COA::orderby($this->sortColumn,$this->sortDir);
        if(!empty($this->searchKeyword)){
            $COA->orWhere('code','like',$this->searchKeyword."%");
            $COA->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $COA = $COA->paginate($this->perPage);

        return view('livewire.beginning-balance.table',['COA' => $COA]);
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
}
