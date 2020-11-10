<?php

namespace Mateu\Backend\Race\Domain;

use InvalidArgumentException;

class RaceCode
{
    public function __construct(string $code)
    {
        if (!is_string($code)) {
            throw new InvalidArgumentException('Must be string');
        }

        if (strlen($code) < 2 || strlen($code) > 15) {
            throw new InvalidArgumentException('Code must be between 2 and 15 chars');
        }

        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }
}
