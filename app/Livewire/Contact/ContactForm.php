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
    public $type = '';
    public $address = '';
	public $pic = '';
	public $mobile = '';
	public $mobile2 = '';
	public $email = '';
	public $nonpwp = '';
	public $npwpnm = '';
	public $status = '';

    public function render()
    {
        return view('livewire.contact.contact-form');
    }

    public function mount(Request $request)
    {
        $contact = Contact::Find($request->id);
        $this->set_id = $contact->id ?? '';
        $this->name = $contact->name ?? '';
        $this->type = $contact->type ?? '';
        $this->address = $contact->address ?? '';
		$this->pic = $contact->pic ?? '';
		$this->mobile = $contact->mobile ?? '';
		$this->mobile2 = $contact->mobile2 ?? '';
		$this->email = $contact->email ?? '';
		$this->nonpwp = $contact->nonpwp ?? '';
		$this->npwpnm = $contact->npwpnm ?? '';
		$this->status = $contact->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                'mobile' => 'required',
            ]);

            $contact = Contact::create([
			'name' => $this->name,
			'type' => $this->type,
			'address' => $this->address,
			'pic' => $this->pic,
			'mobile' => $this->mobile,
			'mobile2' => $this->mobile2,
			'email' => $this->email,
			'nonpwp' => $this->nonpwp,
			'npwpnm' => $this->npwpnm,
			'status' => $this->status,
			
			]);
            session()->flash('success', __('Contact saved'));
            return redirect()->route('contact.form',$contact->id);
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
            session()->flash('success', __('Contact saved'));
        }
    }
}
