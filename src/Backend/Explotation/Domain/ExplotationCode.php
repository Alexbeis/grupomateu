<?php

namespace Mateu\Backend\Explotation\Domain;

use Assert\Assert;

class ExplotationCode
{
    /**
     * @var string
     *
     */
    private $code;

    public function __construct($code)
    {
        Assert::that($code, 'Código Explotación: Obligatorio, entre 2 y 10 caracteres')
            ->notEmpty()
            ->string()
            ->betweenLength(2,10);

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