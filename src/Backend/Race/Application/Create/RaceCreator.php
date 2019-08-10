<?php

namespace Mateu\Backend\Race\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Race\Domain\Entity\Race;
use Mateu\Backend\Race\Domain\RaceRepositoryInterface;

class RaceCreator
{
    private $raceRepository;
    private $em;

    public function __construct(RaceRepositoryInterface $raceRepository, EntityManagerInterface $em)
    {
        $this->raceRepository = $raceRepository;
        $this->em = $em;
    }

    public function create($uuid, $code, $name)
    {
        $race = Race::create($uuid, $code, $name);

        $this->raceRepository->save($race);
        $this->em->flush();

        // TODO: Dispatch Related Events
    }
}