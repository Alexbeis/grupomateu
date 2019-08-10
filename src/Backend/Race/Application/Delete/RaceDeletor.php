<?php

namespace Mateu\Backend\Race\Application\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Mateu\Backend\Race\Domain\RaceAlreadyUsedByAnimals;
use Mateu\Backend\Race\Domain\RaceNotFound;
use Mateu\Backend\Race\Infraestructure\RaceRepository;

class RaceDeletor
{
    private $raceRepository;
    private $em;

    public function __construct(RaceRepository $raceRepository, EntityManagerInterface $em)
    {
        $this->raceRepository = $raceRepository;
        $this->em = $em;
    }

    public function delete($id)
    {
        if (!$this->raceRepository->exist($id)) {
            throw new RaceNotFound('Raza no encontrada');
        }

        $race = $this->raceRepository->findOneBy(['id' => $id]);

        if ($race->getAnimal()->count() > 0) {
            throw new RaceAlreadyUsedByAnimals(
                sprintf('Raza utilizada por %s animales', $race->getAnimal()->count())
            );
        }
        try{
            $this->raceRepository->delete($race);
            $this->em->flush();
        } catch (Exception $e) {
            dd(get_class($e));
        }
    }

}