<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class ShowUser extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.users.show-user');
    }
}
