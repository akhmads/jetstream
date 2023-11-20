<?php

namespace App\Livewire\Bank;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bank;

class BankTable extends Component
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
        $bank = Bank::orderby($this->sortColumn,$this->sortDir)->select('*');
        if(!empty($this->searchKeyword)){
            $bank->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $banks = $bank->paginate($this->perPage);

        return view('livewire.bank.bank-table',['banks' => $banks]);
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

        Bank::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Bank has been deleted'));
    }
}
