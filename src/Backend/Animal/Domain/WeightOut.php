<?php

namespace Mateu\Backend\Animal\Domain;

use Mateu\Shared\Domain\ValueObject\IntValueObject;

class WeightOut extends IntValueObject
{
    public function __construct(?int $value)
    {
        $this->value = $value;
    }
}