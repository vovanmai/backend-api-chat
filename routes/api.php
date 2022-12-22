<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('v1')
->group(function () {
    //Route authenticate
    Route::post('auth', 'AuthenticateController@authenticate');
    Route::post('register', 'AuthenticateController@register');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('profile', 'AuthenticateController@getProfile');
        Route::get('logout', 'AuthenticateController@logout');

        //Route chat_channel api
        require __DIR__ . '/api/chat_channel.php';

        //Route chat_message api
        require __DIR__ . '/api/chat_message.php';
    });
});

