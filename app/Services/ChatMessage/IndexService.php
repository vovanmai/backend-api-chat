<?php

namespace App\Services\ChatMessage;

use App\Data\Repositories\Eloquent\ChatChannelRepository;
use App\Data\Repositories\Eloquent\ChatMessageRepository;
use App\Models\ChatMessage;

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
     * List messages
     *
     * @param $chatChannelId
     *
     * @return ChatMessage
     */
    public function handle(int $chatChannelId)
    {
        $this->chatChannelRepo->find($chatChannelId);

        return $this->chatMessageRepo
            ->with(['sender', 'reactMessage'])
            ->orderBy('id', 'DESC')
            ->whereByField('chat_channel_id', $chatChannelId)
            ->cursorPaginate(30);
    }
}
