<?php

namespace App\Http\Requests;

use App\Exceptions\FormRequestValidatorException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Failed validation
     *
     * @param Validator $validator Validator.
     *
     * @return void
     * @throws FormRequestValidatorException FormRequestValidator.
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new FormRequestValidatorException())->setValidator($validator);
    }
}
