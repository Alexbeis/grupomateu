<?php

namespace Mateu\Shared\Application\Validation;

use Doctrine\Common\Collections\ArrayCollection;

class ViolationList
{
    /**
     * @var array
     */
    private $violations;

    /**
     * ViolationList constructor.
     *
     * @param array $violations
     */
    public function __construct(array $violations = [])
    {
        $this->violations = new ArrayCollection($violations);
    }

    public function add(Violation $violation)
    {
        $this->violations->add($violation);
    }

    public function violations()
    {
        return $this->violations;
    }

    public function toArray()
    {
        return array_map(
            function(Violation $violation){
                return (string) $violation;
            }
        , $this->violations->toArray());
    }
}