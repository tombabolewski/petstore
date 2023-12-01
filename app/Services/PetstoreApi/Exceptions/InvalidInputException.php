<?php

namespace App\Services\PetstoreApi\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class InvalidInputException extends UnprocessableEntityHttpException
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct(
            'API returned an Invalid Input error. Please correct the provided data and try again.',
            $previous
        );
    }
}
