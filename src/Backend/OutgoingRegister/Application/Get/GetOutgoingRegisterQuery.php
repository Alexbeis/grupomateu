<?php

namespace Mateu\Backend\OutgoingRegister\Application\Get;

class GetOutgoingRegisterQuery
{
    private $uuid;

    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid():string
    {
        return $this->uuid;
    }
}
