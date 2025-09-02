<?php
namespace App\Http\Controllers;

use RecentlyViewed\Facades\RecentlyViewed;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::parent(0)->active()->latest()->paginate(60);
        return view('category.categories', compact('categories'));
    }

    public function category($category)
    {
        $Alias        = explode('/', $category)[0] ?? '';
        $checkProduct = \App\Models\Product::active()->whereAlias($Alias)->exists();
        if ($checkProduct) {
            return $this->productInfo($category);
        }

        $explode  = explode('/', $category);
        $parentid = '';
        $category = '';
        foreach ($explode as $exp) {
            $category = \App\Models\Category::whereAlias($exp)->active()->firstOrFail();
            $parentid = $category->parent_id;
        }
        $faqs = $category->faqs()->active()->get();
        if ($category->products()->count() > 0) {

            $products = \App\Models\Product::whereHas('categories', function ($query) use ($category) {
                return $query->category($category['id']);
            })->search()->active()->paginate(60);
            if (request()->ajax()) {
                return response()->json([
                    'results' => view('category.filter', compact('products','category'))->render(),
                ]);
            }
            return view('category.product-lists', compact('category', 'parentid', 'faqs', 'explode'));
        }
        return view('category.lists', compact('category', 'parentid', 'explode', 'faqs'));
    }

    public function productInfo($product)
    {
        $explode = explode('/', $product);
        $Alias   = $explode[0] ?? '';
        $product = \App\Models\Product::whereHas('categories', function ($qry) {
            $qry->whereHas('categoryInfo', function ($qr) {
                $qr->active();
            });
        })->active()->whereAlias($Alias)->firstOrFail();

        $categoryInfo = $product->categories[0]->categoryInfo;
        if (request('cat')) {
            $categoryInfo =  \App\Models\Category::whereAlias(request('cat'))->active()->firstOrFail();
        }

        $colors = \App\Models\ProductVariant::whereHas('variantInfo', function ($qwer) {
            $qwer->active();
        })->whereVariantId(7)->whereProductId($product->id)->get();

        $sizes = \App\Models\ProductVariant::whereHas('variantInfo', function ($qwer) {
            $qwer->active();
        })->whereVariantId(1)->whereProductId($product->id)->get();

        $metals = \App\Models\ProductVariant::whereHas('variantInfo', function ($qwer) {
            $qwer->active();
        })->whereVariantId(3)->whereProductId($product->id)->get();

        $highlights = \App\Models\ProductVariant::whereHas('variantInfo', function ($qwer) {
            $qwer->active();
        })->whereNotIn('variant_id', [1, 3, 7])->whereProductId($product->id)->groupBy('variant_id')->get();

        // $sizes           = \App\Models\ProductVariant::whereProductId($product->id)->groupBy('variant_id')->get();
        // $colors          = \App\Models\ProductColor::whereProductId($product->id)->get();
        // $selectedcolor   = \App\Models\ProductColor::whereProductId($product->id)->whereAlias(end($explode))->firstOrFail();
        // $selectedvariant = \App\Models\ProductVariant::whereProductId($selectedcolor->product_id)->whereColorId($selectedcolor->id)->whereVariantId(request('pid'))->firstOrFail();
        $images = $product->images ?? '';

        $facilities = \App\Models\Facilities::active()->get();
        $related    = \App\Models\Product::related($product)->get();
        RecentlyViewed::add($product);

        $galleries = \App\Models\Gallery::type(1)->active()->latest()->get();
        $videos    = \App\Models\Gallery::type(2)->active()->latest()->get();
        return view('category.product', compact('product', 'categoryInfo', 'galleries', 'videos', 'facilities', 'related', 'images', 'highlights', 'colors', 'metals', 'sizes'));
    }
}
