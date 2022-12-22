<?php

namespace App\Data\Exceptions;

use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class ForbiddenException extends BaseException
{
    protected $httpStatusCode = Response::HTTP_FORBIDDEN;
}
