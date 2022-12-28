<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat-to-channel-{channelId}', function ($channelId, $user) {
    return true;
});

Broadcast::channel('chat-user-{userId}', function ($userId, $user) {
    return true;
});

Broadcast::channel('react-in-{channelId}', function ($channelId, $user) {
    return true;
});

Broadcast::channel('user-online', function ($user) {
    return $user;
});
