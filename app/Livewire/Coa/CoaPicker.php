<?php

namespace App\Livewire\Coa;

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Livewire\WithPagination;
use App\Models\Coa;

class CoaPicker extends Component
{
    use WithPagination;

    //#[Modelable]
    public $value = '';
    public $index = '';

    public $label;
    public $searchKeyword;
    public $modal = false;
    public $class;

    public function render()
    {
        $coa = Coa::orderBy('code');
        if(!empty($this->searchKeyword)){
            $coa->where('code','ilike',$this->searchKeyword."%");
            $coa->orWhere('name','ilike',"%".$this->searchKeyword."%");
        }
        $coas = $coa->simplePaginate(20);
        return view('livewire.coa.coa-picker',['coas' => $coas]);
    }

    public function mount($index = '', $value = '')
    {
        if( !empty($value) ){
            $coa = Coa::where('code',$value)->get()->first();
        }
        $this->index = $index;
        $this->value = $coa->code ?? '';
        $code = $coa->code ?? '';
        $name = $coa->name ?? '';
        $this->label = empty($code) ? '' : $code . ' - ' . $name;
    }

    public function pick($id,$label,$index='')
    {
        $this->value = $id;
        $this->label = $label;
        $this->modal = false;
        $this->dispatch('set-coa', id: $id, index: $this->index);
    }
}
