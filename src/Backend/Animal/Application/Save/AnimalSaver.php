<?php

namespace Mateu\Backend\Animal\Application\Save;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Application\Find\AnimalFinder;
use Mateu\Backend\Animal\Domain\AnimalNotFound;
use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Race\Domain\RaceNotFound;
use Mateu\Backend\Race\Domain\RaceRepositoryInterface;

final class AnimalSaver
{
    /**
     * @var AnimalRepositoryInterface
     */
    private $animalRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var AnimalFinder
     */
    private $animalFinder;
    /**
     * @var RaceRepositoryInterface
     */
    private $raceRepository;

    public function __construct(
        AnimalRepositoryInterface $animalRepository,
        RaceRepositoryInterface $raceRepository,
        EntityManagerInterface $em,
        AnimalFinder $animalFinder
    )
    {
        $this->animalRepository = $animalRepository;
        $this->em = $em;
        $this->animalFinder = $animalFinder;
        $this->raceRepository = $raceRepository;
    }

    public function save($id, $crotal, $crotalMother, $internalNum, $weightIn, $weightOut, $birthdate, $genre, $raceId)
    {
        if (!$animal = $this->animalFinder->find($id)) {
            throw new AnimalNotFound(sprintf('animal con %d no existe', $id));
        }

        if (!$race = $this->raceRepository->findOneById($raceId)) {
            throw new RaceNotFound('Raza no encontrada');
        }

        /**
         * @var Animal $animal
         */
        $animal
            ->setCrotal($crotal)
            ->setCrotalMother($crotalMother)
            ->setInternalNum($internalNum)
            ->setWeightIn($weightIn)
            ->setWeightOut($weightOut)
            ->setBirthDate(new \DateTime($birthdate))
            ->setGenre($genre)
            ->setRace($race);

        $this->animalRepository->save($animal);
        $this->em->flush();
    }
}