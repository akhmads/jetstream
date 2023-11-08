<?php

namespace App\Livewire\Widget;

use Livewire\Component;
use App\Models\User;

class UserCard extends Component
{
    public $title;
    public $icon;
    public $counter;

    public function mount($type = '')
    {
        if($type == 'invoice'){
            $this->title = 'Total Invoice';
            $this->icon = 'invoice';
            $this->counter = 987;
        }else if($type == 'cash'){
            $this->title = 'Total Cash';
            $this->icon = 'cash';
            $this->counter = number_format(134000000,0);
        }else if($type == 'bank'){
            $this->title = 'Total Bank';
            $this->icon = 'bank';
            $this->counter = number_format(243890455,0);
        }else{
            $this->title = 'Total Users';
            $this->icon = 'users';
            $this->counter = User::select('id')->count();
        }
    }

    public function render()
    {
        return view('livewire.widget.user-card');
    }

    public function placeholder()
    {
        return view('livewire.widget.user-card-placeholder');
    }
}
