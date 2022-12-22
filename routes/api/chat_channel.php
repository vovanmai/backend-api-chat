<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use Illuminate\Support\Facades\Route;

Route::prefix('chat-channels')->group(function () {
    Route::get('', 'ChatChannelController@index');
    Route::get('{id}', 'ChatChannelController@show');
    Route::get('{id}/messages', 'ChatMessageController@index');
    Route::post('{id}/read', 'ChatChannelController@read');
});
