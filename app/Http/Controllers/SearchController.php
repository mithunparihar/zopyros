<?php
namespace App\Http\Controllers;
use DB;
class SearchController extends Controller
{
    public function makeSearchQuery($query)
    {
        $products = \App\Models\Product::active()->where('title', 'LIKE', '%' . $query . '%')
            ->select('id', 'alias', 'title', DB::raw("'products' as source"));

        $categories = \App\Models\Category::active()->where('title', 'LIKE', '%' . $query . '%')
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
