<?php

namespace App\Livewire\Widget;

use Livewire\Component;
use App\Models\User;

class UserCard extends Component
{
    public function render()
    {
        return view('livewire.widget.user-card');
    }

    public function placeholder()
    {
        return view('livewire.widget.user-card-placeholder');
    }
}
