<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;

class ContactPicker extends Component
{
    use WithPagination;

    // #[Modelable]
    public $value = '';

    public $label;
    public $searchKeyword;
    public $disabled = false;
    public $modal = false;

    public function render()
    {
        $contact = Contact::orderBy('name');
        if(!empty($this->searchKeyword)){
            $contact->where('name','ilike',"%".$this->searchKeyword."%");
        }
        $contacts = $contact->simplePaginate(20);
        return view('livewire.contact.contact-picker',['contacts' => $contacts]);
    }

    public function mount($value = '', $disabled = false)
    {
        if( !empty($value) ){
            $contact = Contact::where('id',$value)->get()->first();
        }
        $this->value = $contact->id ?? '';
        $this->label = $contact->name ?? '';
        $this->disabled = $disabled;
    }

    public function pick($id,$label)
    {
        $this->value = $id;
        $this->label = $label;
        //$this->searchKeyword = $this->label;
        $this->modal = false;
        $this->dispatch('set-contact', id: $id);
    }

    public function updated()
    {
        $this->resetPage();
    }
}
