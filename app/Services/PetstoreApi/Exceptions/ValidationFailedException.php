<?php

namespace App\Services\PetstoreApi\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ValidationFailedException extends UnprocessableEntityHttpException
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('API returned a Validation error. Please correct your input and try again.', $previous);
    }
}
