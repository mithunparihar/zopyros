<?php
namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductBox extends Component
{
    public $product;
    public $lowestPrice;
    public $colorInfo, $images;
    public $className;
    public function mount(Product $product,$class=null)
    {
        $this->product     = $product;
        $this->lowestPrice = $product->lowestPrice[0];
        $this->colorInfo   = $this->lowestPrice->colorInfo;
        $this->images      = $this->colorInfo->images;
        $this->className      = $class;
    }
    public function render()
    {
        return view('livewire.product-box');
    }
}
