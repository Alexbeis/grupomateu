<?php

namespace Mateu\Backend\Dashboard\Infraestructure\Controller;

use Mateu\Backend\Dashboard\Application\GetResumeBoxes\GetResumeBoxesQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/", name="index_dashboard")
     * @return Response
     */
    public function __invoke()
    {
        $envelope = $this->ask(new GetResumeBoxesQuery());
        $handledStamp = $envelope->last(HandledStamp::class);

        return new Response(
            $this->render('dashboard/index.html.twig', [
                    'totals' => $handledStamp->getResult()
                ]
            )
        );
    }
}
