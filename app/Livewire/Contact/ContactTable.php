<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            $keyword = strtoupper($this->searchKeyword);
            $contact->where(function($query){
                $query->where(DB::raw('UPPER(name)'),'like',"%".$keyword."%");
                $query->orWhere(DB::raw('UPPER(email)'),'like',"%".$keyword."%");
                $query->orWhere(DB::raw('UPPER(contact_type)'),'like',"%".$keyword."%");
                $query->orWhere(DB::raw('UPPER(contact_code)'),'like',"%".$keyword."%");
            });
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
        return redirect()->route('master.contact');
    }
}
