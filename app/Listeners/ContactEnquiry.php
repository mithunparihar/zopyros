<?php

namespace App\Listeners;

use App\Events\ContactEnquiry as ContactEnquiryEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Contact as ContactNotification;

class ContactEnquiry implements ShouldQueue
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
    public function handle(ContactEnquiryEvent $event): void
    {
        $requestData = $event->requestData;
        $this->sendNotification($requestData);
        $this->sendMail($requestData);
    }

    function sendMail($requestData){
        $admin = \Content::adminData();
        if (!empty($admin->mail_received_email)) {
            foreach (explode(',', $admin->mail_received_email) as $key => $email) {
                \Mail::to($email)->send(new \App\Mail\Admin\ContactEnquiry($requestData));
            }
        }
    }

    function sendNotification($requestData){
        $admin = \Content::adminData();
        $admin->notify(new ContactNotification($requestData));
    }
}
