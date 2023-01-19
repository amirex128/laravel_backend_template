<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class IndexUser extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::query()->paginate(10);
    }

    public function render()
    {
        return view('livewire.users.index-user');
    }
}
