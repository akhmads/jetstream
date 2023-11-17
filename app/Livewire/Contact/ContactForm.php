<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Code;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContactForm extends Component
{
    public $set_id;
    public $cust_code = '';
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
        $this->cust_code = $contact->cust_code ?? '[auto]';
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
            'cust_code' => $this->autocode(),
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
            $contact->update([
			'cust_code' => $this->cust_code,
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
        }
    }

    protected function autocode(): string
    
    {
        $prefix = 'C'.date('y').'/'.date('m').'/';
        Code::updateOrCreate(
            ['prefix' => $prefix],
            ['num' => DB::raw('num+1')]
        );
        $cust_code = Code::where('prefix', $prefix)->first();
        return $cust_code->prefix . Str::padLeft($cust_code->num, 4, '0');
    }
}
