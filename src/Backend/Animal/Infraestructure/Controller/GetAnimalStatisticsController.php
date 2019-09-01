<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use Mateu\Backend\Animal\Application\GetAnimalsPerRace\GetAnimalsPerRaceQuery;
use Mateu\Backend\Animal\Application\GetAnimalTotalsPerExplotation\GetAnimalTotalsPerExplotationQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class GetAnimalStatisticsController extends BaseController implements ControllerInterface
{
    /**
     * @Route("animals/statistics", name="animal_statistics", methods={"POST"})
     */
    public function __invoke()
    {
        $envelopeOne = $this->ask(new GetAnimalTotalsPerExplotationQuery());
        $handledStampOne = $envelopeOne->last(HandledStamp::class);

        $envelopeTwo = $this->ask(new GetAnimalsPerRaceQuery());
        $handledStampTwo = $envelopeTwo->last(HandledStamp::class);

        return $this->createSuccessResponse(
            null,
            [
                $handledStampOne->getResult(),
                $handledStampTwo->getResult()
            ]
        );
    }

}