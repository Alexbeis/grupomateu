<?php

namespace Mateu\Shared\Domain\ValueObject\Validators;

interface Validable
{
    public function validate($value);
}