<?php

namespace Mateu\Backend\Animal\Application\GetAnimalsPerRace;

use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;

final class GetAnimalsRacesStatistics
{
    private $animalRepository;

    public function __construct(AnimalRepositoryInterface $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    public function compute()
    {
        return $this->adaptToChart(
            $this->animalRepository->computeTotalsPerRace()
        );
    }

    private function adaptToChart($data)
    {
        return array_merge(
            [
                'labels' => array_map(function ($el) {
                    return $el['name'];
                }, $data)
            ],
            [
                'totals' => array_map(function ($el) {
                    return $el['total'];
                }, $data)
            ],
            [
                'label' => 'Razas Actuales en las explotaciones',
                'type' => 'doughnut',
                'id' => '#razas-chart'
            ]
        );
    }

}