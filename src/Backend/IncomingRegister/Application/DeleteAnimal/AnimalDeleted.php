<?php

namespace Mateu\Backend\IncomingRegister\Application\DeleteAnimal;

class AnimalDeleted
{
    private $incRegisterId;

    public function __construct($incRegisterId)
    {
        $this->incRegisterId = $incRegisterId;
    }

    /**
     * @return mixed
     */
    public function getIncRegisterId()
    {
        return $this->incRegisterId;
    }
}