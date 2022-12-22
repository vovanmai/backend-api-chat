<?php

namespace App\Http\Requests\ChatMessage;

use App\Http\Requests\Request;

class ReactMessageRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
        ];
    }
}
