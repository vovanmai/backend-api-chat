<?php

namespace App\Services\ChatChannel;

use App\Data\Repositories\Eloquent\ChatChannelRepository;
use App\Data\Repositories\Eloquent\ChatMessageRepository;
use App\Data\Repositories\Eloquent\UnreadMessageTotalRepository;
use App\Events\SendMessage;
use App\Models\ChatChannel;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReadChannelService
{

    /**
     * @var ChatChannelRepository
     */
    protected $chatChannelRepo;

    /**
     * @var ChatMessageRepository
     */
    protected $chatMessageRepo;

    /**
     * @var UnreadMessageTotalRepository
     */
    protected $unreadMessageTotalRepo;

    public function __construct(
        ChatChannelRepository $chatChannelRepo,
        ChatMessageRepository $chatMessageRepo,
        UnreadMessageTotalRepository $unreadMessageTotalRepo
    ) {
        $this->chatChannelRepo = $chatChannelRepo;
        $this->chatMessageRepo = $chatMessageRepo;
        $this->unreadMessageTotalRepo = $unreadMessageTotalRepo;
    }

    /**
     * Store a message
     *
     * @param $data
     *
     * @return ChatMessage
     */
    public function handle(int $id)
    {
        $chatChannel = $this->chatChannelRepo->find($id);

        $this->resetMessageTotal($chatChannel);

        return $chatChannel->unreadMessageTotal;
    }

    /**
     * ResetMessageTotal
     *
     * @param ChatChannel $chatChannel
     *
     * @return mixed
     */
    private function resetMessageTotal(ChatChannel $chatChannel)
    {
        $unreadTotalMessage = $this->unreadMessageTotalRepo->firstWhere([
            'chat_channel_id' => $chatChannel->id,
            'user_id' => Auth::id(),
        ]);

        if ($unreadTotalMessage) {
            $unreadTotalMessage->update([
                'number_of_unread' => 0,
            ]);
        }
    }
}
