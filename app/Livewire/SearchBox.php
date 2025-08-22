<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBox extends Component
{
    
    public $results;
    protected $listeners=['autoSearchData'=>'autoSearchData'];
    public function render()
    {
        return view('livewire.search-box');
    }
    
    public function autoSearchData($query)
    {
        $controller    = new \App\Http\Controllers\SearchController();
        $this->results = $controller->makeSearchQuery($query);
    }
}
