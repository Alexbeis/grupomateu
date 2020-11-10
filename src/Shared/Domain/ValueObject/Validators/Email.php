<?php

namespace Mateu\Shared\Domain\ValueObject\Validators;

class Email implements Validable
{
    public function validate($value)
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)){
            throw new \Exception('Not a valid Email');
        }
        return true;
    }
}