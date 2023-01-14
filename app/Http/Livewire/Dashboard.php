<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $m=['name'=>''];

    public function render()
    {
        return view('dashboard')->layoutData(['title'=>'داشبورد سلورا']);
    }
}
