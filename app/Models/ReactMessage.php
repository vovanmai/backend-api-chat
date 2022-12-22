<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReactMessage extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'react_message';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_message_id',
        'user_id',
        'type',
    ];
}
