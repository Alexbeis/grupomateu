<?php

namespace Mateu\Backend\Animal\Application\Find;

use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;

Final class AnimalFinder
{
    private $animalRepository;

    public function __construct(AnimalRepositoryInterface $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    public function find($id)
    {
        return $this->animalRepository->findOneById($id);
    }
}