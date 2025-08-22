<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactEnquiry as ContactEnquiryEmail;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ContactEnquiry implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $requestData;
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-channel.1'),
        ];
    }

    public function broadcastWith()
    {
        \Log::info('Contact Request Recieved');
        return [
            'message' => "New Contact Request Recieved!",
        ];
    }
}
