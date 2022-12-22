<?php

namespace App\Exceptions;

use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class FormRequestValidatorException extends BaseException
{
    /**
     * Status code Http
     *
     * @var int Status code
     */
    protected $httpStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * Validator
     *
     * @var Validator
     */
    public $validator;

    /**
     * Set validator
     *
     * @param mixed $validator Validator.
     *
     * @return $this
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get errors
     *
     * @return mixed
     */
    public function errors()
    {
        $errors = $this->getMessageBag()->messages();

        foreach ($errors as $key => $item) {
            if (is_array($item)) {
                $errors[$key] = $item[0];
            }
        }

        return $errors;
    }

    /**
     * An alternative more semantic shortcut to the message container.
     *
     * @return \Illuminate\Support\MessageBag
     */
    protected function getMessageBag()
    {
        return $this->validator->errors();
    }

    /**
     * Get message
     *
     * @return string
     */
    protected function message()
    {
        return trans('messages.validate.fail');
    }
}
