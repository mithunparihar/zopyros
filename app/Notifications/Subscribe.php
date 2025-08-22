<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Subscribe extends Notification
{
    use Queueable;

    public $subscribeData;
    public function __construct($subscribeData)
    {
        $this->subscribeData = $subscribeData;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'data'=>$this->subscribeData,
            'url' => ''
        ];
    }
}
