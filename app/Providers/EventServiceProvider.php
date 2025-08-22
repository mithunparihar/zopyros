<?php
namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use RecentlyViewed\Facades\RecentlyViewed;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [\App\Listeners\MergeRecentlyViewedOnLogin::class],
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
