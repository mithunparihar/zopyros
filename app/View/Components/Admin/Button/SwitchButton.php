<?php

namespace App\View\Components\Admin\Button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SwitchButton extends Component
{
    public $value,$checked,$url,$dataType='publish';
    public $disabled=false;
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.button.switch');
    }
}
