<?php

namespace App\Livewire\Contact;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;

class ContactTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "id";
    public $sortDir = "desc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $confirmDeletion = false;
    public $set_id;

    public function render()
    {
        $contact = Contact::orderby($this->sortColumn,$this->sortDir)->select('*');
        if(!empty($this->searchKeyword)){
            $contact->orWhere('name','like',"%".$this->searchKeyword."%");
            $contact->orWhere('email','like',"%".$this->searchKeyword."%");
        }
        $contacts = $contact->paginate($this->perPage);

        return view('livewire.contact.contact-table',['contacts' => $contacts]);
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

        Contact::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Contact has been deleted'));
        return redirect()->to('/contact');
    }
}
