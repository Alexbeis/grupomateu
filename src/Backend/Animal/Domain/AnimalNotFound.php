<?php

namespace Mateu\Backend\Animal\Domain;

use Exception;
use Throwable;

class AnimalNotFound extends Exception
{
    const MESSAGE = 'Animal no encontrado';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
    }
}