<?php
namespace App\Http\Controllers;

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
        if ($category->products()->count() > 0) {
            $faqs     = $category->faqs()->active()->get();
            $products = \App\Models\Product::whereHas('categories', function ($query) use ($category) {
                return $query->category($category['id']);
            })->active()->paginate(60);
            if (request()->ajax()) {
                return response()->json([
                    'results' => view('category.filter', compact('products'))->render(),
                ]);
            }
            return view('category.product-lists', compact('category', 'parentid', 'faqs', 'explode'));
        }
        return view('category.lists', compact('category', 'parentid', 'explode'));
    }

    public function productInfo($product)
    {
        $explode         = explode('/', $product);
        $Alias           = $explode[0] ?? '';
        $product         = \App\Models\Product::active()->whereAlias($Alias)->firstOrFail();
        $sizes           = \App\Models\ProductVariant::whereProductId($product->id)->groupBy('variant_id')->get();
        $colors          = \App\Models\ProductColor::whereProductId($product->id)->get();
        $selectedcolor   = \App\Models\ProductColor::whereProductId($product->id)->whereAlias(end($explode))->firstOrFail();
        $selectedvariant = \App\Models\ProductVariant::whereProductId($selectedcolor->product_id)->whereColorId($selectedcolor->id)->whereVariantId(request('pid'))->firstOrFail();
        $images          = $selectedcolor->images ?? '';
        return view('category.product', compact('product', 'sizes', 'selectedcolor', 'selectedvariant', 'images', 'colors'));
    }
}
