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
    /**
     * @var string
     */
    private $newExplotationCode;
    /**
     * @var string|null
     */
    private $oldExplotationCode;

    public function __construct(
        int $incomingRegisterId,
        string $incomingRegisterUuid,
        int $animalId,
        string $crotal,
        string $newExplotationCode,
        ?string $oldExplotationCode

    ) {
        $this->incomingRegisterId = $incomingRegisterId;
        $this->incomingRegisterUuid = $incomingRegisterUuid;
        $this->animalId = $animalId;
        $this->crotal = $crotal;
        $this->newExplotationCode = $newExplotationCode;
        $this->oldExplotationCode = $oldExplotationCode;
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

    /**
     * @return string
     */
    public function getNewExplotationCode(): string
    {
        return $this->newExplotationCode;
    }

    /**
     * @return string|null
     */
    public function getOldExplotationCode(): ?string
    {
        return $this->oldExplotationCode;
    }

}