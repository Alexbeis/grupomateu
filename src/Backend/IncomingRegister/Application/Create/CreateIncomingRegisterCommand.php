<?php

namespace Mateu\Backend\IncomingRegister\Application\Create;

class CreateIncomingRegisterCommand
{
    private $uuid;
    private $inTypeId;
    private $procedende;
    private $explotationId;
    private $supplierId;

    public function __construct($uuid, $inTypeId, $procedende, $explotationId, $supplierId)
    {

        $this->uuid = $uuid;
        $this->inTypeId = $inTypeId;
        $this->procedende = $procedende;
        $this->explotationId = $explotationId;
        $this->supplierId = $supplierId;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getInTypeId()
    {
        return $this->inTypeId;
    }

    /**
     * @return mixed
     */
    public function getProcedende()
    {
        return $this->procedende;
    }

    /**
     * @return mixed
     */
    public function getExplotationId()
    {
        return $this->explotationId;
    }

    /**
     * @return mixed
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }
}