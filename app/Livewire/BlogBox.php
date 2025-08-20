<?php
namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class BlogBox extends Component
{

    public $blog;
    public $className;

    public function mount(Blog $blog, $class = null)
    {
        $this->blog      = $blog;
        $this->className = $class;
    }

    public function render()
    {
        return view('livewire.blog-box');
    }
}
