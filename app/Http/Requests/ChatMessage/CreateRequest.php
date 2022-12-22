<?php

namespace App\Http\Requests\ChatMessage;

use App\Http\Requests\Request;

class CreateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'chat_channel_id' => 'required|exists:chat_channels,id',
            'message' => 'required',
        ];
    }
}
