<?php

namespace App\Data\Repositories\Eloquent;

use App\Models\ChatChannel;
use App\Models\UnreadMessageTotal;

class UnreadMessageTotalRepository extends AppBaseRepository
{
    /**
     * Attribute searchable
     *
     * @var array
     */
    protected $fieldSearchable = [
        'sender_id' => ['column' => 'chat_channels.sender_id', 'operator' => '=', 'type' => 'normal'],
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return UnreadMessageTotal::class;
    }
}
