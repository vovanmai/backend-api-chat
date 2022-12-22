<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReactMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reactMessage;
    public $channelId;

    public function __construct($reactMessage, $channelId)
    {
        $this->reactMessage = $reactMessage;
        $this->channelId = $channelId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("react-in-{$this->channelId}");
    }

    public function broadcastAs()
    {
        return 'react-message';
    }
}
