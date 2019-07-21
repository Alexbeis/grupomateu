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

        if (strlen($code) == 0 || strlen($code) > 10) {
           throw new InvalidArgumentException('Code must be 10 or less chars');
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