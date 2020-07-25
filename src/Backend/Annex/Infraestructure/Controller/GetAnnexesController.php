<?php

namespace Mateu\Backend\Annex\Infraestructure\Controller;

use Mateu\Backend\Annex\Application\GetAll\GetAllAnnexesQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetAnnexesController
 * @package Mateu\Backend\Annex\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class GetAnnexesController extends BaseController implements ControllerInterface
{
    /**
     * @Route(
     *     {
     *      "en" : "/annexes",
     *      "es" : "/marcados"
     *     },
     *     name="index_annexes")
     * @return Response
     */
    public function __invoke()
    {
        $envelope = $this->ask(new GetAllAnnexesQuery());
        $handledStamp = $envelope->last(HandledStamp::class);

        return new Response(
            $this->render(
                'annex/index.html.twig',
                [
                    'annexes' => $handledStamp->getResult()
                ]
            )
        );

    }

}