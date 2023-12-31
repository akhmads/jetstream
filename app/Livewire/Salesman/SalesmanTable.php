<?php

namespace App\Livewire\Salesman;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Salesman;

class SalesmanTable extends Component
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
        $salesman = Salesman::orderby($this->sortColumn,$this->sortDir)->select('*');
        if(!empty($this->searchKeyword)){
            $salesman->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $salesman = $salesman->paginate($this->perPage);

        return view('livewire.salesman.salesman-table',['salesmans' => $salesman]);
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

        Salesman::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Salesman has been deleted'));
        return redirect()->to('/salesman');
    }
}
