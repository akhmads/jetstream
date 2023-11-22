<?php

namespace App\Livewire\BankAccount;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bank;
use App\Models\BankAccount;

class BankAccountTable extends Component
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
        $BankAccount = BankAccount::orderby($this->sortColumn,$this->sortDir)->select('*')->with('bank:id,name')->with('coa:code,name');
        if(!empty($this->searchKeyword)){
            $BankAccount->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $BankAccount = $BankAccount->paginate($this->perPage);

        return view('livewire.bank-account.bank-account-table',['BankAccounts' => $BankAccount]);
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
        session()->flash('success', __('Bank account has been deleted'));
    }
}
