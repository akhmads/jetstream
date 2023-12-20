<?php

namespace App\Livewire\CashTrans;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CashTrans;
use App\Models\CashTransDetail;
use App\Models\GLhd;
use App\Models\GLdt;

class CashTransTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "cash_trans.id";
    public $sortDir = "desc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $filterStatus = '';
    public $confirmDeletion = false;
    public $resource_type;
    public $set_id;

    public function mount($type)
    {
        $this->resource_type = $type;
    }

    public function render()
    {
        $CashTrans = CashTrans::select('cash_trans.*')
            ->orderby($this->sortColumn,$this->sortDir)
            ->leftJoin('cash_account','cash_account.id','=','cash_trans.cash_account_id')
            ->leftJoin('contact','contact.id','=','cash_trans.contact_id')
            ->where('cash_trans.type',$this->resource_type)
            ->with('contact:id,name')
            ->with('account:id,name');
        if(!empty($this->searchKeyword)){
            $CashTrans->where(function($query){
                $query->where('cash_trans.code','ilike',"%".$this->searchKeyword."%");
                $query->orWhere('cash_account.name','ilike',"%".$this->searchKeyword."%");
                $query->orWhere('contact.name','ilike',"%".$this->searchKeyword."%");
            });
        }
        if(!empty($this->filterStatus)){
            $CashTrans->where('cash_trans.status',$this->filterStatus);
        }
        $data = $CashTrans->paginate($this->perPage);

        return view('livewire.cash-trans.cash-trans-table',['data' => $data]);
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
        $CashTrans = CashTrans::where('id', $this->set_id)->first();
        CashTransDetail::where('code', $CashTrans->code ?? '')->delete();

        $GLhd = GLhd::where('ref_id', $CashTrans->code ?? '')->first();
        GLdt::where('code', $GLhd->code ?? '')->delete();
        if(!empty($GLhd)) $GLhd->delete();

        $CashTrans->delete();

        $this->confirmDeletion = false;
        session()->flash('success', __('Data has been deleted'));
    }
}
