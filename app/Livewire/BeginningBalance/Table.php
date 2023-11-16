<?php

namespace App\Livewire\BeginningBalance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Coa;
use App\Models\BeginningBalance;

class Table extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "code";
    public $sortDir = "asc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $coa_code = '';
    public $coa_name = '';
    public $year = '';
    public $debit = '';
    public $credit = '';
    public $updateModal = false;
    public $set_id;

    public function render()
    {
        if(empty($this->year)){
            $this->year = date('Y');
        }
        $COA = Coa::orderby($this->sortColumn,$this->sortDir);
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

    public function store()
    {
        if (BeginningBalance::where('year',$this->year)->where('coa_code',$this->coa_code)->count() > 0)
        {
            $valid = $this->validate([
                'debit' => '',
                'credit' => '',
            ]);

            $BB = BeginningBalance::where('year',$this->year)->where('coa_code',$this->coa_code);
            $BB->update($valid);
            session()->flash('success', __('Balance saved'));
        }
        else
        {
            $valid = $this->validate([
                'year' => 'required',
                'coa_code' => 'required',
                'debit' => '',
                'credit' => '',
            ]);

            BeginningBalance::create($valid);
            session()->flash('success', __('Balance saved'));
        }

        $this->coa_code = '';
        $this->coa_name = '';
        $this->updateModal = false;
    }

    public function edit($year,$coa_code,$coa_name)
    {
        $this->year = $year;
        $this->coa_code = $coa_code;
        $this->coa_name = $coa_name;

        $this->resetErrorBag();
        $this->resetValidation();
        $this->updateModal = true;
    }
}
