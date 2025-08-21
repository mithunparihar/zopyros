<?php

namespace App\Livewire;

use Livewire\Component;

class Footer extends Component
{
    public $categories=[];

    function mount(){
        $this->categories = \App\Models\Category::active()->footer()->get();
    }
    public function render()
    {
        return view('livewire.footer');
    }
}
