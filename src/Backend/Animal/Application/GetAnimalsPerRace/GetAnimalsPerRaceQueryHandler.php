<?php

namespace Mateu\Backend\Animal\Application\GetAnimalsPerRace;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAnimalsPerRaceQueryHandler implements MessageHandlerInterface
{
    private $animalsRacesStatistics;

    public function __construct(GetAnimalsRacesStatistics $animalsRacesStatistics)
    {
        $this->animalsRacesStatistics = $animalsRacesStatistics;
    }

    public function __invoke(GetAnimalsPerRaceQuery $animalsPerRaceQuery)
    {
        return $this->animalsRacesStatistics->compute();
    }
}
