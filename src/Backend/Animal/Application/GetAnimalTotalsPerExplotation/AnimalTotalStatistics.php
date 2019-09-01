<?php

namespace Mateu\Backend\Animal\Application\GetAnimalTotalsPerExplotation;

use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;

final class AnimalTotalStatistics
{
    private $animalRepository;

    public function __construct(AnimalRepositoryInterface $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    public function compute()
    {
        return  $this->adaptToChart(
            $this->animalRepository->computeTotalsPerExplotation()
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
                'label' => 'Explotaciones con animales',
                'type' => 'doughnut',
                'id' => '#explotaciones-chart'
            ]
        );
    }
}
