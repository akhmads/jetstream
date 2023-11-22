<?php

namespace App\Livewire\Coa;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Coa;

class CoaTable extends Component
{
    use WithPagination;

    public $perPage = '';
    public $sortColumn = "code";
    public $sortDir = "asc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $confirmDeletion = false;
    public $set_id;

    public function mount()
    {
        if(!session(get_class($this).'perPage')){
            session([ get_class($this).'perPage' => 10 ]);
        }
        $this->perPage = $this->perPage ? $this->perPage : session(get_class($this).'perPage');
        $this->searchKeyword = $this->searchKeyword ? $this->searchKeyword : session(get_class($this).'searchKeyword');
    }

    public function render()
    {
        //dd(session()->all());
        session([ get_class($this).'perPage' => $this->perPage ]);
        session([ get_class($this).'searchKeyword' => $this->searchKeyword ]);

        $coa = Coa::orderby($this->sortColumn,$this->sortDir)->select('*');
        if(!empty($this->searchKeyword)){
            $coa->orWhere('code','like',"%".$this->searchKeyword."%");
            $coa->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $coas = $coa->paginate($this->perPage);

        return view('livewire.coa.coa-table',['coas' => $coas]);
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

        Coa::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Coa has been deleted'));
    }
}
