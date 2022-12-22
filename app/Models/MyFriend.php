<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyFriend extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'my_friend_id',
    ];
}
