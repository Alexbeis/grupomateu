<?php

namespace Mateu\Backend\Race\Domain;

use InvalidArgumentException;

class RaceName
{
    public function __construct(string $name)
    {
        if (strlen($name) < 3 || strlen($name) > 50) {
            throw new InvalidArgumentException('Name must be between 3 and 50 chars');
        }

        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
