<?php

namespace Mateu\Backend\Animal\Application\GetAnimalTotalsPerExplotation;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAnimalTotalsPerExplotationQueryHandler implements MessageHandlerInterface
{
    private $animalTotalStatistics;

    public function __construct(AnimalTotalStatistics $animalTotalStatistics)
    {
        $this->animalTotalStatistics = $animalTotalStatistics;
    }

    public function __invoke(GetAnimalTotalsPerExplotationQuery $animalTotalsPerExplotationQuery)
    {
        return $this->animalTotalStatistics->compute();
    }
}
