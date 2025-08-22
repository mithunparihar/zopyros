<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Career extends Notification
{
    use Queueable;

    public $requestData;
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'data'=>$this->requestData,
            'url' => ''
        ];
    }
}
