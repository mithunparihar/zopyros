<?php
namespace App\Http\Controllers;

use DB;

class SearchController extends Controller
{
    public function search()
    {
        $query     = trim(request('q'));
        $products   = \App\Models\Product::active()->search($query)->paginate(30);
        $categories = \App\Models\Category::active()->search($query)->get();
        return view('search', compact('products', 'categories'));
    }

    public function makeSearchQuery($query)
    {
        $products = \App\Models\Product::active()->search($query)
            ->select('id', 'alias', 'title', DB::raw("'products' as source"));

        $categories = \App\Models\Category::active()->search($query)
            ->select('id', 'alias', 'title', DB::raw("'categories' as source"));

        $results = $products->unionAll($categories);
        $results = $results->limit(20)->get();

        if (! empty($query)) {
            return $results;
        } else {
            return [];
        }

    }
}
