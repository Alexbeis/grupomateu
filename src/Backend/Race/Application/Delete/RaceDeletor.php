<?php

namespace Mateu\Backend\Race\Application\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Mateu\Backend\Race\Infraestructure\RaceRepository;

class RaceDeletor
{
    /**
     * @var RaceRepository
     */
    private $raceRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(RaceRepository $raceRepository, EntityManagerInterface $em)
    {
        $this->raceRepository = $raceRepository;
        $this->em = $em;
    }

    public function delete($id)
    {
        if (!$this->raceRepository->exist($id)) {
            throw new Exception('Raza no válida');
        }

        $race = $this->raceRepository->findOneBy(['id' => $id]);

        $this->raceRepository->delete($race);
        $this->em->flush();
    }

}