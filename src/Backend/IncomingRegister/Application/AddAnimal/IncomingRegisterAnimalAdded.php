<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal;

class IncomingRegisterAnimalAdded
{
    /**
     * @var int
     */
    private $incomingRegisterId;

    public function __construct(int $incomingRegisterId)
    {
        $this->incomingRegisterId = $incomingRegisterId;
    }

    /**
     * @return int
     */
    public function getIncomingRegisterId(): int
    {
        return $this->incomingRegisterId;
    }
}