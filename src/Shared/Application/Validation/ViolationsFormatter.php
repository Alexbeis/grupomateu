<?php

namespace Mateu\Shared\Application\Validation;

class ViolationsFormatter
{
    /**
     * @var ViolationList
     */
    private $violationList;

    public function __construct(ViolationList $violationList)
    {
        $this->violationList = $violationList;
    }

    public function toString()
    {
        $result = "";
        foreach ($this->violationList->violations() as $violation) {
            $result .= $violation->getMessage() . ",";
        }

        return trim($result, ',');
    }
}