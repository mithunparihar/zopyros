<?php
namespace App\Livewire;

use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Variant;
use Livewire\Component;

class Filter extends Component
{
    public $category;
    public $variants;
    public $maxprice;
    public function mount(Category $category)
    {
        $this->category = $category;
        $this->variants = Variant::whereHas('childs', function ($qwert) {
            $qwert->active();
        })->with(['childs' => function ($qwert) {
            $qwert->active();
        }])->parent(0)->active()->get();

        $this->maxprice = ProductVariant::whereHas('productInfo', function ($qwert) use ($category) {
            $qwert->whereHas('categories', function ($qwer) use ($category) {
                $qwer->category($category->id);
            });
        })->max('price');
    }

    public function render()
    {
        return view('livewire.filter');
    }
}
