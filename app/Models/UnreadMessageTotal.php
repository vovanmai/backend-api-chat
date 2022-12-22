<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnreadMessageTotal extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unread_message_total';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_channel_id',
        'user_id',
        'number_of_unread',
    ];
}
