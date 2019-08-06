<?php

namespace Mateu\Backend\Race\Application\Create;

class CreateRaceCommand
{
    private $code;
    private $name;
    private $uuid;

    public function __construct(string $uuid, string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
