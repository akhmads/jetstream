<?php

namespace App\Livewire\Example;

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactPicker extends Component
{
    #[Modelable]
    public $value = '';
    public $label = '-- Choose --';

    public $modal = false;

    public function render()
    {
        $contacts = Contact::orderBy('id')->get();
        return view('livewire.example.contact-picker',['contacts' => $contacts]);
    }

    public function mount($value = '')
    {
        $this->value = $value;
    }

    public function pick($id)
    {
        $contact = Contact::find($id)->get()->first();

        $this->value = $id;
        $this->label = $contact->name ?? '';
        $this->modal = false;
    }
}
