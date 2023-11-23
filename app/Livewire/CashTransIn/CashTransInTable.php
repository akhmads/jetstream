<?php

namespace App\Livewire\CashTransIn;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CashTrans;
use App\Models\CashTransDetail;

class CashTransInTable extends Component
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
        $CashTrans = CashTrans::orderby($this->sortColumn,$this->sortDir);
        if(!empty($this->searchKeyword)){
            $CashTrans->orWhere('glhd.code','like',"%".$this->searchKeyword."%");
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
        $CashTrans = CashTrans::where('id',$this->set_id)->orderBy('id')->first();
        $CashTransDetail = CashTransDetail::where('code',$CashTrans->number);
        $CashTransDetail->delete();
        $CashTrans->delete();

        $this->confirmDeletion = false;
        session()->flash('success', __('Data has been deleted'));
    }
}
