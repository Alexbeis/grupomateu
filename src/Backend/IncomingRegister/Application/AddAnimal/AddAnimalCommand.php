<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal;

class AddAnimalCommand
{
    /**
     * @var int
     */
    private $incRegisterId;
    /**
     * @var string
     */
    private $data;

    public function __construct(int $incRegisterId, string $data)
    {
        $this->incRegisterId = $incRegisterId;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getIncRegisterId(): int
    {
        return $this->incRegisterId;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }
}