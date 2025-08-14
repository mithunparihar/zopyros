<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImagePreview extends Component
{
    public $pathName,$imageName;
    public function __construct($imagepath,$image,$options=null)
    {
        $this->pathName = $imagepath;
        $this->imageName = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-preview');
    }
}
