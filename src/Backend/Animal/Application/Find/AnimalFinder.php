<?php

namespace Mateu\Backend\Animal\Application\Find;

use Mateu\Backend\Animal\Domain\AnimalRepository;

Final class AnimalFinder
{
    private $animalRepository;

    public function __construct(AnimalRepository $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    public function find($id)
    {
        return $this->animalRepository->findOneById($id);
    }
}