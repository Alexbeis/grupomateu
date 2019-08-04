<?php

namespace Mateu\Backend\InType\Application\Create;

class CreateInTypeCommand
{
    private $uuid;
    private $code;
    private $name;

    public function __construct($uuid, $code, $name)
    {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}