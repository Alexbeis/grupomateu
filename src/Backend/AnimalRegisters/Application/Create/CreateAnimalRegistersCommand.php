<?php

namespace Mateu\Backend\AnimalRegisters\Application\Create;

class CreateAnimalRegistersCommand
{
    private $crotal;
    private $incomingRegisterUuid;

    public function __construct(string $crotal, string $incomingRegisterUuid)
    {
        $this->crotal = $crotal;
        $this->incomingRegisterUuid = $incomingRegisterUuid;
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
    public function getIncomingRegisterUuid(): string
    {
        return $this->incomingRegisterUuid;
    }

}