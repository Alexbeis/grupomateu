<?php

namespace Mateu\Backend\Animal\Domain;

use Mateu\Shared\Domain\ValueObject\StringValueObject;

class CrotalNum extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureLengthString($value);

        parent::__construct($value);
    }

    private function ensureLengthString(string $value)
    {
        preg_match('/^[a-zA-Z0-9]{3,20}$/', $value, $output);

        if (empty($output)) {
            throw new CrotalNumNotValid('Crotal num máximo 20 caracteres y sólo letras y numeros');
        }
    }
}