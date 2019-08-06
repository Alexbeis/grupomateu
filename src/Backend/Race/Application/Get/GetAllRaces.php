<?php

namespace Mateu\Backend\Race\Application\Get;

use Mateu\Backend\Race\Domain\RaceRepositoryInterface;

class GetAllRaces
{
    /**
     * @var RaceRepositoryInterface
     */
    private $raceRepository;

    public function __construct(RaceRepositoryInterface $raceRepository)
    {
        $this->raceRepository = $raceRepository;
    }

    public function get()
    {
        return array_map(function($race) {
           return  [
               'id' => $race->getId(),
               'code' => $race->getCode(),
               'name' => $race->getName()
           ];
        }, $this->raceRepository->getAll());


    }
}