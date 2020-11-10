<?php

namespace Mateu\Backend\User\Domain;

use Mateu\Shared\Domain\ValueObject\StringValueObject;

class Fullname extends StringValueObject
{
    public function __construct(string $value)
    {
        if (strlen($value) < 2 || strlen($value) > 50) {
            throw new \Exception('Full name debe estar entre 2 y 50 caracteres');
        }
        parent::__construct($value);
    }
}