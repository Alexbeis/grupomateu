<?php

namespace Mateu\Backend\Explotation\Domain;

use InvalidArgumentException;

class ExplotationCode
{
    /**
     * @var string
     *
     */
    private $code;

    public function __construct($code)
    {
        if (!is_string($code)) {
            throw new InvalidArgumentException('Must be string');
        }

        if (strlen($code) == 0 || strlen($code) > 20) {
           throw new InvalidArgumentException('Código debe tener 20 caracteres como máximo');
        }

        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}