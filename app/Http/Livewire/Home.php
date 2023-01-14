<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $m=['name'=>''];

    public function render()
    {
        return view('livewire.home')->layoutData(['title'=>'Home']);
    }
}
