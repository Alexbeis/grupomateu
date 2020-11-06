<?php

namespace Mateu\Shared\Application\Validation;

class Violation
{
    private $message;
    private $args;

    public function __construct($message, $args)
    {
        $this->message = $message;
        $this->args = $args?$args:[];
    }

    public function getMessage()
    {
        return vsprintf($this->message, $this->args);
    }

    public function __toString()
    {
        return $this->getMessage();
    }
}