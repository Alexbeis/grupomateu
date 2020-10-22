<?php

namespace Mateu\Backend\Annex\Infraestructure\Controller;

use Mateu\Backend\Annex\Application\GetGroupedByExplotation\GetGroupedByExplotationQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetAnnexesController
 * @package Mateu\Backend\Annex\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class GetGroupedByController extends BaseController implements ControllerInterface
{
    /**
     * @Route(
     *     {
     *      "en" : "/annexes/by-explotation",
     *      "es" : "/marcados/por-explotacion"
     *     },
     *     methods={"GET"},
     *     name="grouped_annexes")
     * @param Request $request
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->createFailResponse();
        }

        $envelope = $this->ask(
            new GetGroupedByExplotationQuery()
        );
        $handledStamp = $envelope->last(HandledStamp::class);

        return $this->createSuccessResponse(null, $handledStamp->getResult());

    }

}