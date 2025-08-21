<?php
namespace App\Livewire;

use Livewire\Component;

class Nav extends Component
{
    public $categories = [];

    public function mount()
    {
        $this->categories = \App\Models\Category::active()->parent(0)->get();
    }

    public function render()
    {
        return view('livewire.nav');
    }
}
