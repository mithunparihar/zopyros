<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind('content',function($app){
            return new \App\Helpers\Content();
        });
        $this->app->bind('commanfunction',function($app){
            return new \App\Helpers\CommanFunction();
        });
        $this->app->bind('image',function($app){
            return new \App\Helpers\Image();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
