<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ChatChannel extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sender_id',
        'receiver_id',
        'last_message',
        'last_message_at',
    ];

    /**
     * ChatChannel belong to User
     *
     * @return BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * ChatChannel belong to user
     *
     * @return BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * ChatChannel belong to many users
     *
     * @return BelongsTo
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_channel_user', 'chat_channel_id', 'user_id');
    }

    /**
     * ChatChannel has one UnreadMessageTotal
     *
     * @return BelongsTo
     */
    public function unreadMessageTotal()
    {
        return $this->hasMany(UnreadMessageTotal::class, 'chat_channel_id');
    }
}
