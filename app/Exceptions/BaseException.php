<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class BaseException extends Exception
{
    protected $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * Render exception
     *
     * @param mixed $request Request.
     *
     * @return mixed
     *
     * @SuppressWarnings("unused")
     */
    public function render($request)
    {
        $errors = $this;
        $message = $this->message;

        if (method_exists($this, 'errors')) {
            $errors = $this->errors();
        }

        if (method_exists($this, 'message')) {
            $message = $this->message();
        }

        return response()->error(
            $errors,
            $message,
            $this->httpStatusCode
        );
    }
}
