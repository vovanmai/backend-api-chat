<?php

namespace App\Data\Repositories\Eloquent;

use App\Models\ReactMessage;

class ReactMessageRepository extends AppBaseRepository
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
        return ReactMessage::class;
    }
}
