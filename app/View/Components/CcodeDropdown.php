<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CcodeDropdown extends Component
{
    public $lists=[];
    public function __construct()
    {
        $this->lists = \App\Models\Country::whereStatus(1)->orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ccode-dropdown');
    }
}
