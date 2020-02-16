<?php

namespace Mateu\Backend\IncomingRegister\Application\DeleteAnimal;

class DeleteAnimalCommand
{
    /**
     * @var int
     */
    private $incomingRegisterId;
    /**
     * @var int
     */
    private $animalId;

    public function __construct(int $incomingRegisterId, int $animalId)
    {
        $this->incomingRegisterId = $incomingRegisterId;
        $this->animalId = $animalId;
    }

    /**
     * @return int
     */
    public function getIncomingRegisterId(): int
    {
        return $this->incomingRegisterId;
    }

    /**
     * @return int
     */
    public function getAnimalId(): int
    {
        return $this->animalId;
    }

}