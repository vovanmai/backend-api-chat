<?php

namespace App\Services\ChatChannel;

use App\Data\Repositories\Eloquent\ChatChannelRepository;
use App\Data\Repositories\Eloquent\ChatMessageRepository;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class IndexService
{

    /**
     * @var ChatChannelRepository
     */
    protected $chatChannelRepo;

    /**
     * @var ChatMessageRepository
     */
    protected $chatMessageRepo;

    public function __construct(
        ChatChannelRepository $chatChannelRepo,
        ChatMessageRepository $chatMessageRepo
    ) {
        $this->chatChannelRepo = $chatChannelRepo;
        $this->chatMessageRepo = $chatMessageRepo;
    }

    /**
     * Store a message
     *
     * @param $data
     *
     * @return ChatMessage
     */
    public function handle()
    {
        $auth = Auth::id();

        return $this->chatChannelRepo
            ->with([
                'sender',
                'receiver',
                'unreadMessageTotal',
            ])
            ->orderBy('last_message_at', 'DESC')
            ->scopeQuery(function ($query) use ($auth) {
                return $query->where(function ($query) use ($auth) {
                    $query->where('sender_id', $auth)->orWhere('receiver_id', $auth);
                });
            })->cursorPaginate(30);
    }
}
