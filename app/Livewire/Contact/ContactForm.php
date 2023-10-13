<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactForm extends Component
{
    public $set_id;
    public $name = '';
    public $email = '';
    public $mobile = '';

    public function render()
    {
        return view('livewire.contact.contact-form');
    }

    public function mount(Request $request)
    {
        $contact = Contact::Find($request->id);
        $this->set_id = $contact->id ?? '';
        $this->name = $contact->name ?? '';
        $this->email = $contact->email ?? '';
        $this->mobile = $contact->mobile ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
            ]);

            $contact = Contact::create($valid);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
            ]);
            $contact = Contact::find($this->set_id);
            $contact->update($valid);
        }

        $this->dispatch('saved');
        session()->flash('success', __('Contact saved'));
    }
}
