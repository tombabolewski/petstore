<?php

namespace App\Services\PetstoreApi\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PetNotFoundException extends NotFoundHttpException
{
    public function __construct(\Throwable $previous)
    {
        parent::__construct('Pet not found', $previous);
    }
}
