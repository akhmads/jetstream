<?php

namespace App\Livewire\CashTransIn;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CashTrans;
use App\Models\CashTransDetail;
use App\Models\GLhd;
use App\Models\GLdt;

class CashTransInTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "cash_trans.id";
    public $sortDir = "desc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $confirmDeletion = false;
    public $set_id;

    public function render()
    {
        $CashTrans = CashTrans::select('cash_trans.*')
            ->orderby($this->sortColumn,$this->sortDir)
            ->leftJoin('cash_account','cash_account.id','=','cash_trans.cash_account_id')
            ->where('type','in')
            ->with('contact:id,name')
            ->with('account:id,name');
        if(!empty($this->searchKeyword)){
            $CashTrans->orWhere('code','like',"%".$this->searchKeyword."%");
            $CashTrans->orWhere('cash_account.name','like',"%".$this->searchKeyword."%");
        }
        $data = $CashTrans->paginate($this->perPage);

        return view('livewire.cash-trans-in.cash-trans-in-table',['data' => $data]);
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
        $CashTrans = CashTrans::where('id', $this->set_id)->orderBy('id')->first();
        CashTransDetail::where('code', $CashTrans->code ?? '')->delete();

        $GLhd = GLhd::where('ref_id', $CashTrans->code ?? '')->first();
        GLdt::where('code', $GLhd->code ?? '')->delete();
        if(!empty($GLhd)) $GLhd->delete();

        $CashTrans->delete();

        $this->confirmDeletion = false;
        session()->flash('success', __('Data has been deleted'));
    }
}
