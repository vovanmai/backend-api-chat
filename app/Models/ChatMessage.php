<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_channel_id',
        'sender_id',
        'message',
    ];

    /**
     * ChatMessage belong to chatChannel
     *
     * @return BelongsTo
     */
    public function chatChannel()
    {
        return $this->belongsTo(ChatChannel::class);
    }

    /**
     * ChatMessage belong to User
     *
     * @return BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * ChatMessage belong to User
     *
     * @return BelongsTo
     */
    public function reactMessage()
    {
        return $this->hasOne(ReactMessage::class, 'chat_message_id');
    }
}
