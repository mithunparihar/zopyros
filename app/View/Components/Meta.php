<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Meta extends Component
{
    public $title="";
    public $description="";
    public $keywords="";
    public $options,$type="website";

    public function __construct($options=null)
    {
        $this->title = $options['title'] ?? $this->title;
        $this->keywords = $options['keywords'] ?? $this->keywords;
        $this->description = $options['description'] ?? $this->description;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.meta');
    }
}
