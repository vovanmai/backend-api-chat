<?php

namespace App\Services\ChatMessage;

use App\Data\Repositories\Eloquent\ChatChannelRepository;
use App\Data\Repositories\Eloquent\ChatMessageRepository;
use App\Data\Repositories\Eloquent\UnreadMessageTotalRepository;
use App\Events\SendMessage;
use App\Models\ChatChannel;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreService
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
    public function handle(array $data)
    {
        $chatChannel = $this->chatChannelRepo->find($data['chat_channel_id'], [
            'id',
            'sender_id',
            'receiver_id',
            'last_message',
            'created_at',
        ]);

        $chatChannel->update([
            'last_message'=> $data['message'],
            'last_message_at'=> now()->format('Y-m-d H:i:s.u'),
        ]);
        $this->updateMessageTotal($chatChannel);

        $data['sender_id'] = Auth::id();
        $chatMessage = $this->chatMessageRepo->create($data);
        $chatMessage->react_message = null;

        broadcast(new SendMessage($chatChannel, $chatMessage));

        return [
            'channel' => $chatChannel,
            'message' => $chatMessage,
        ];
    }

    /**
     * UpdateMessageTotal
     *
     * @param ChatChannel $chatChannel
     *
     * @return mixed
     */
    private function updateMessageTotal(ChatChannel $chatChannel)
    {
        $receiverId = $chatChannel->sender_id == Auth::id() ? $chatChannel->receiver_id : $chatChannel->sender_id;

        $unreadTotalMessage = $this->unreadMessageTotalRepo->firstWhere([
            'chat_channel_id' => $chatChannel->id,
            'user_id' => $receiverId,
        ]);

        $this->unreadMessageTotalRepo->updateWhere([
            'chat_channel_id' => $chatChannel->id,
            'user_id' => Auth::id(),
        ], [
            'number_of_unread' => 0,
        ]);

      if ($unreadTotalMessage) {
            return $unreadTotalMessage->update([
                'number_of_unread' => DB::raw('number_of_unread + 1'),
            ]);
        }

        return $this->unreadMessageTotalRepo->create([
            'chat_channel_id' => $chatChannel->id,
            'number_of_unread' => 1,
            'user_id' => $receiverId,
        ]);
    }
}
