<?php

namespace App\Events;

use App\Models\ChatChannel;
use App\Models\ChatMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $channel;

    public function __construct(ChatChannel $channel, ChatMessage $message)
    {
        $this->channel = $channel;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel("chat-to-channel-{$this->channel->id}"),
            new PrivateChannel("chat-user-{$this->channel->sender->id}"),
            new PrivateChannel("chat-user-{$this->channel->receiver->id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'send-message';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $this->channel->load([
            'sender' => function ($query) {
                return $query->select([
                    'id',
                    'full_name',
                    'color',
                    \DB::raw('false as active'),
                ]);
            },
            'receiver' => function ($query) {
                return $query->select([
                    'id',
                    'full_name',
                    'color',
                    \DB::raw('false as active'),
                ]);
            },
            'unreadMessageTotal' => function ($query) {
                return $query->select([
                    'chat_channel_id',
                    'user_id',
                    'number_of_unread',
                ]);
            }
        ]);

        $this->message->load([
            'sender' => function ($query) {
                return $query->select([
                    'id',
                    'full_name',
                ]);
            },
        ]);

        return [
            'channel' => $this->channel,
            'message' => $this->message,
        ];
    }
}
