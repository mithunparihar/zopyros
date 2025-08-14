<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    public const HOME = '/';
    public const ADMINHOME = '/control-panel/dashboard';

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // \Route::middleware('web')
        //     ->domain(env('SubDomain_3W').'admin.'.env('SubDomain'))
        //     ->group(base_path('routes/admin.php'));
    }

}
