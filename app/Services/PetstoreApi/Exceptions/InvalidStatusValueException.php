<?php

namespace App\Services\PetstoreApi\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class InvalidStatusValueException extends UnprocessableEntityHttpException
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('API returned an Invalid Status Value error. Please contact the administrator.', $previous);
    }
}
