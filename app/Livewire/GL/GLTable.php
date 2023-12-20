<?php

namespace App\Livewire\GL;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\GLhd;
use App\Models\GLdt;

class GLTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "id";
    public $sortDir = "asc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $coa_code = '';
    public $confirmDeletion = false;
    public $set_id;

    public function render()
    {
        $GL = GLhd::orderby($this->sortColumn,$this->sortDir)
                ->select(['glhd.*','gldt.debit','gldt.credit','gldt.coa_code','coa.name as coa_name'])
                ->leftJoin('gldt', 'gldt.code', '=', 'glhd.code')
                ->leftJoin('coa', 'coa.code', '=', 'gldt.coa_code');
        if(!empty($this->searchKeyword)){
            $GL->where(function($query){
                $query->orWhere('glhd.code','ilike',$this->searchKeyword."%");
                $query->orWhere('gldt.coa_code','ilike',$this->searchKeyword."%");
                $query->orWhere('coa.name','ilike',"%".$this->searchKeyword."%");
            });
        }
        $GL->where('gldt.coa_code','=',$this->coa_code);
        $GL = $GL->paginate($this->perPage);

        return view('livewire.gl.gl-table',['GL' => $GL]);
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
        $hd = GLhd::where('id',$this->set_id)->orderBy('id')->first();
        GLdt::where('code',$hd->code);
        $hd->delete();

        $this->confirmDeletion = false;
        session()->flash('success', __('GL has been deleted'));
    }

    #[On('set-coa')]
    public function setCoa( $id )
    {
        $this->coa_code = $id;
        $this->resetPage();
    }
}
