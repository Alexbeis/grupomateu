<?php

namespace Mateu\Shared\Application\Validation;

class ExecutionContext
{
    private $violationList;

    public function __construct()
    {
        $this->violationList = new ViolationList();
    }

    public function addViolation(Violation $violation)
    {
        $this->violationList->add($violation);
    }

    public function getViolations()
    {
        return $this->violationList;
    }
}