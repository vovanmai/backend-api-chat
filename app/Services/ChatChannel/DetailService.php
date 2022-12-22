<?php

namespace App\Services\ChatChannel;

use App\Data\Repositories\Eloquent\ChatChannelRepository;
use App\Data\Repositories\Eloquent\ChatMessageRepository;
use App\Models\ChatChannel;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class DetailService
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
     * show a channel
     *
     * @param int $id
     *
     * @return ChatChannel
     */
    public function handle(int $id)
    {
        return $this->chatChannelRepo
            ->with(['sender', 'receiver'])
            ->find($id);
    }
}
