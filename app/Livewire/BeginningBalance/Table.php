<?php

namespace App\Livewire\BeginningBalance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use App\Hyco\Cast;
use App\Models\Coa;
use App\Models\BeginningBalance;
use Closure;

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
    public $dc = 'D';
    public $amount = '';
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
        if (BeginningBalance::select('id')->where('year',$this->year)->where('coa_code',$this->coa_code)->count() > 0)
        {
            $valid = $this->validate([
                'dc' => 'required',
                'amount' => 'required|min:1|gt:1',
            ]);

            $amount = Cast::number($this->amount);
            $BB = BeginningBalance::where('year',$this->year)->where('coa_code',$this->coa_code);
            $BB->update([
                'dc' => $this->dc,
                'debit' => $this->dc=='D' ? $this->amount : 0,
                'credit' => $this->dc=='C' ? $this->amount : 0,
                'amount' => $this->dc=='D' ? $amount : $amount * -1,
            ]);
            session()->flash('success', __('Balance saved'));
        }
        else
        {
            $valid = $this->validate([
                'year' => 'required',
                'coa_code' => 'required',
                'amount' => 'required|min:1|gt:1',
            ]);

            $amount = Cast::number($this->amount);
            BeginningBalance::create([
                'year' => $this->year,
                'coa_code' => $this->coa_code,
                'dc' => $this->dc,
                'debit' => $this->dc=='D' ? $this->amount : 0,
                'credit' => $this->dc=='C' ? $this->amount : 0,
                'amount' => $this->dc=='D' ? $amount : $amount * -1,
            ]);
            session()->flash('success', __('Balance saved'));
        }

        $this->coa_code = '';
        $this->coa_name = '';
        $this->updateModal = false;
    }

    public function edit($year,$coa_code,$coa_name)
    {
        $COA = Coa::where('code',$coa_code)->first();
        $BB = BeginningBalance::where('year',$year)
            ->where('coa_code',$coa_code)
            ->first();

        $this->coa_code = $COA->code ?? '';
        $this->coa_name = $COA->name ?? '';
        $this->dc = $BB->dc ?? 'D';
        $this->amount = abs($BB->amount ?? 0);

        $this->resetErrorBag();
        $this->resetValidation();
        $this->updateModal = true;
    }
}
