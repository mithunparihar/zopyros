<?php

namespace App\Events;

use App\Models\Subscribe as SubscribeEmail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class Subscribe implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscribeData;
    public function __construct(SubscribeEmail $subscribe)
    {
        $this->subscribeData = $subscribe;
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
        \Log::info('Subscribe Request Recieved');
        return [
            'message' => "New Subscribe Request Recieved!",
        ];
    }
}
