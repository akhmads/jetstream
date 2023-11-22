<?php

namespace App\Livewire\Currency;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Currency;

class CurrencyTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "id";
    public $sortDir = "desc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $confirmDeletion = false;
    public $set_id;

    public function mount()
    {
        $this->searchKeyword = $this->searchKeyword ? $this->searchKeyword : session(get_class($this).'searchKeyword');
    }

    public function render()
    {
        //dd(session()->all());
        session([ get_class($this).'searchKeyword' => $this->searchKeyword ]);

        $currency = Currency::orderby($this->sortColumn,$this->sortDir)->select('*');
        if(!empty($this->searchKeyword)){
            $currency->orWhere('code','like',"%".$this->searchKeyword."%");
            $currency->orWhere('name','like',"%".$this->searchKeyword."%");
            $currency->orWhere('status','like',"%".$this->searchKeyword."%");
        }
        $currencies = $currency->paginate($this->perPage);

        return view('livewire.currency.currency-table',['currencies' => $currencies]);
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

        Currency::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Currency has been deleted'));
    }
}
