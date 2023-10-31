<?php

namespace App\Livewire\Example;

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactPicker extends Component
{
    // #[Modelable]
    public $value = '';

    public $label = '-- Choose --';
    public $setvalue = '';
    public $searchKeyword;
    public $modal = false;

    public function render()
    {
        $contact = Contact::orderBy('id');
        if(!empty($this->searchKeyword)){
            $contact->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $contacts = $contact->limit(20)->get();
        return view('livewire.example.contact-picker',['contacts' => $contacts]);
    }

    public function mount($value = '')
    {
        if( !empty($value) ){
            $contact = Contact::where('id',$value)->get()->first();
        }
        $this->value = $contact->id ?? '';
        $this->label = $contact->name ?? '';
        $this->setvalue = $this->value;
        $this->searchKeyword = $this->label;
    }

    public function pick($id,$label)
    {
        $this->value = $id;
        $this->label = $label;
        $this->setvalue = $this->value;
        $this->searchKeyword = $this->label;
        $this->modal = false;
        $this->dispatch('set-contact', id: $id);
    }
}
