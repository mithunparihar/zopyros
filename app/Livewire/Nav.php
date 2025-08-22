<?php
namespace App\Livewire;

use Livewire\Component;

class Nav extends Component
{
    public $categories = [];
    public $results;
    protected $listeners=['autoSearchData'=>'autoSearchData'];
    public function mount()
    {
        $this->categories = \App\Models\Category::active()->parent(0)->get();
    }

    public function render()
    {
        return view('livewire.nav');
    }

    public function autoSearchData($query)
    {
        $controller    = new \App\Http\Controllers\SearchController();
        $this->results = $controller->makeSearchQuery($query);
        dd($this->results);
    }
}
