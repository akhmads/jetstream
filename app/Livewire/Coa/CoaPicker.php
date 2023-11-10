<?php

namespace App\Livewire\Coa;

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Livewire\WithPagination;
use App\Models\Coa;

class CoaPicker extends Component
{
    use WithPagination;

    #[Modelable]
    public $value = '';

    public $label;
    public $searchKeyword;
    public $modal = false;
    public $class;

    public function render()
    {
        $coa = Coa::orderBy('code');
        if(!empty($this->searchKeyword)){
            $coa->orWhere('code','like',$this->searchKeyword."%");
            $coa->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $coas = $coa->paginate(20);
        return view('livewire.coa.coa-picker',['coas' => $coas]);
    }

    public function mount($value = '')
    {
        if( !empty($value) ){
            $coa = Coa::where('code',$value)->get()->first();
        }
        $this->value = $coa->code ?? '';
        $this->label = $coa->name ?? '';
    }

    public function pick($id,$label)
    {
        $this->value = $id;
        $this->label = $label;
        //$this->searchKeyword = $this->label;
        $this->modal = false;
        $this->dispatch('set-coa', id: $id);
    }
}
