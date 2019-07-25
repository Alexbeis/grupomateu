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
        $all = $this->raceRepository->getAll();
        $result = [];

        foreach ($all as $race) {
            $result[] = [
                'id' => $race->getId(),
                'name' => $race->getName()
            ];
        }

        return $result;
    }

}