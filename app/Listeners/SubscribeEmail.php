<?php

namespace App\Listeners;

use App\Events\Subscribe;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Subscribe as SubscribeNotification;
class SubscribeEmail implements ShouldQueue
{

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Subscribe $event): void
    {
        $subscribeData = $event->subscribeData;
        $this->sendNotification($subscribeData);
    }

    function sendNotification($subscribeData){
        $admin = \Content::adminData();
        $admin->notify(new SubscribeNotification($subscribeData));
    }
}
