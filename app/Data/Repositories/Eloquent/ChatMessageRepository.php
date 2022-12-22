<?php

namespace App\Data\Repositories\Eloquent;

use App\Models\ChatMessage;

class ChatMessageRepository extends AppBaseRepository
{
    /**
     * Attribute searchable
     *
     * @var array
     */
    protected $fieldSearchable = [
        'sender_id' => ['column' => 'chat_messages.sender_id', 'operator' => '=', 'type' => 'normal'],
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return ChatMessage::class;
    }
}
