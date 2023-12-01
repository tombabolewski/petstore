<?php

namespace App\Services\PetstoreApi\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnknownApiErrorException extends HttpException
{
    public function __construct(\Throwable $previous)
    {
        parent::__construct(500, 'API returned an unknown error. Please contact the administrator.', $previous);
    }
}
