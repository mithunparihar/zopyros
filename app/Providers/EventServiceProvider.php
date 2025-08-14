<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\Subscribe::class => [ \App\Listeners\SubscribeEmail::class],
        \App\Events\ContactEnquiry::class => [ \App\Listeners\ContactEnquiry::class],
        \App\Events\CareerEnquiry::class => [ \App\Listeners\CareerEnquiry::class],
        \App\Events\FreeEstimation::class => [ \App\Listeners\FreeEstimation::class],
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
