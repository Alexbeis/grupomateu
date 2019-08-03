<?php

namespace Mateu\Shared\Domain\ValueObject\Uuid;

class Uuid
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function random()
    {
        return new self(UuidGenerator::generate());
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}