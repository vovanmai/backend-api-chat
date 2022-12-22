<?php

namespace App\Services\ChatMessage;

use App\Data\Repositories\Eloquent\ChatMessageRepository;
use App\Data\Repositories\Eloquent\ReactMessageRepository;
use App\Events\ReactMessage;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ReactMessageService
{

    /**
     * @var ReactMessageRepository
     */
    protected $reactMessageRepo;

    /**
     * @var ChatMessageRepository
     */
    protected $chatMessageRepo;

    public function __construct(
        ChatMessageRepository $chatMessageRepo,
        ReactMessageRepository $reactMessageRepo
    ) {
        $this->chatMessageRepo = $chatMessageRepo;
        $this->reactMessageRepo = $reactMessageRepo;
    }

    /**
     * React a message
     *
     * @param $data
     *
     * @return ChatMessage
     */
    public function handle(int $id, array $data)
    {
        $chat = $this->chatMessageRepo->find($id);

        $react = $this->reactMessageRepo->updateOrCreate([
            'user_id' => Auth::id(),
            'chat_message_id' => $id,
        ], [
            'type' => $data['type']
        ]);

        broadcast(new ReactMessage($react, $chat->chatChannel->id));

        return $react;
    }
}
