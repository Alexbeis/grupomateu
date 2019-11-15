<?php

namespace Mateu\Backend\Animal\Application\Move;

class MoveAnimalCommand
{
    private $explotationTo;
    private $animals;

    public function __construct($explotationTo, array $animals)
    {
        $this->explotationTo = $explotationTo;
        $this->animals = $animals;
    }

    /**
     * @return array
     */
    public function getAnimals(): array
    {
        return $this->animals;
    }

    /**
     * @return mixed
     */
    public function getExplotationTo()
    {
        return $this->explotationTo;
    }
}