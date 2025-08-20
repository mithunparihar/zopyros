<?php
namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryBox extends Component
{
    public $category;
    public $className;

    public function mount(Category $category,$class=null)
    {
        $this->category = $category;
        $this->className = $class;
    }

    public function render()
    {
        return view('livewire.category-box');
    }
}
