<?php

namespace Mateu\Backend\OutgoingRegister\Application\Create;

class CreateOutgoingRegisterCommand
{
    private $explotationCode;
    private $uuid;

    public function __construct(string $explotationCode, $uuid)
    {
        $this->explotationCode = $explotationCode;
        $this->uuid = $uuid;
    }

    public function getExplotationCode(): string
    {
        return $this->explotationCode;
    }

    public function getUuid():string
    {
        return $this->uuid;
    }
}
