<?php

namespace App\View\Components\Comman;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\SocialMedia;
class SocialIcon extends Component
{
    public $icons;
    public $className;
    public function __construct($class=null)
    {
        $this->className = $class;
        $this->icons = SocialMedia::whereNotNull('link')->active()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comman.social-icon');
    }
}
