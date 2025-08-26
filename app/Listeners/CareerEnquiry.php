<?php

namespace App\Listeners;

use App\Events\CareerEnquiry as CareerModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Career as CareerNotification;

class CareerEnquiry implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CareerModel $event): void
    {
        $requestData = $event->requestData;
        $this->sendNotification($requestData);
        $this->sendMail($requestData);
    }

    function sendMail($requestData){
        if (!empty($requestData->email)) {
            \Mail::to($requestData->email)->send(new \App\Mail\Career($requestData));
        }

        $admin = \Content::adminData();
        if (!empty($admin->mail_received_email)) {
            foreach (explode(',', $admin->mail_received_email) as $key => $email) {
                \Mail::to($email)->send(new \App\Mail\Admin\Career($requestData));
            }
        }
    }

    function sendNotification($requestData){
        $admin = \Content::adminData();
        $admin->notify(new CareerNotification($requestData));
    }
}
