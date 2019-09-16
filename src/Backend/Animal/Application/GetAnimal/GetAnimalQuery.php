<?php

namespace Mateu\Backend\Animal\Application\GetAnimal;

class GetAnimalQuery
{
    /**
     * @var int
     */
    private $animalId;

    public function __construct(int $animalId)
    {
        $this->animalId = $animalId;
    }

    /**
     * @return int
     */
    public function getAnimalId(): int
    {
        return $this->animalId;
    }
}