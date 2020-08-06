<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal;

class IncomingRegisterAnimalAdded
{
    /**
     * @var int
     */
    private $incomingRegisterId;

    /**
     * @var string
     */
    private $incomingRegisterUuid;

    /**
     * @var int
     */
    private $animalId;

    /**
     * @var string
     */
    private $crotal;

    public function __construct(int $incomingRegisterId, string $incomingRegisterUuid, int $animalId, string $crotal)
    {
        $this->incomingRegisterId = $incomingRegisterId;
        $this->incomingRegisterUuid = $incomingRegisterUuid;
        $this->animalId = $animalId;
        $this->crotal = $crotal;
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

    /**
     * @return string
     */
    public function getIncomingRegisterUuid() : string
    {
        return $this->incomingRegisterUuid;
    }

    /**
     * @return string
     */
    public function getCrotal(): string
    {
        return $this->crotal;
    }
}