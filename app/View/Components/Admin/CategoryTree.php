<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryTree extends Component
{
    public $category;
    public $prepermission=[];
    public function __construct($category,$prepermission=[])
    {
        $this->prepermission = $prepermission ?? [];
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.category-tree');
    }
}
