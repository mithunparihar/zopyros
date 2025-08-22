<?php
namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use RecentlyViewed\Facades\RecentlyViewed;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $recentProducts = RecentlyViewed::get(Product::class, 10);
            $productIds     = $recentProducts->pluck('id');
            $recentProducts = Product::active()
                ->whereIn('id', $productIds)
                ->whereNot('alias',request()->segment(1))
                ->get();
            $view->with('recentProducts', $recentProducts);
        });
    }
}
