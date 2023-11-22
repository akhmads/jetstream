<?php

namespace App\Livewire\CashAccount;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CashAccount;

class CashAccountTable extends Component
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
        $CashAccount = CashAccount::orderby($this->sortColumn,$this->sortDir)->select('*')->with('coa:code,name');
        if(!empty($this->searchKeyword)){
            $CashAccount->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $CashAccount = $CashAccount->paginate($this->perPage);

        return view('livewire.cash-account.cash-account-table',['CashAccounts' => $CashAccount]);
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

        Cash::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Cash account has been deleted'));
    }
}
