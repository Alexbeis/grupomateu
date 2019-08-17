<?php

namespace Mateu\Backend\Explotation\Infraestructure\Controller;

use Mateu\Backend\Explotation\Application\GetAll\GetExplotationsQuery;
use Mateu\Backend\Group\Application\GetAll\GetAllGroupsQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AllExplotationsController
 * @IsGranted("ROLE_ADMIN")
 */
class AllExplotationsController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/explotations" ,name="index_explotations")
     * @param ContainerInterface $container
     *
     * @return Response
     */
    public function __invoke()
    {
        $envelope = $this->ask(new GetExplotationsQuery());
        $handledStamp = $envelope->last(HandledStamp::class);

        $envGroup = $this->ask(new GetAllGroupsQuery());
        $handledS = $envGroup->last(HandledStamp::class);

        return $this->render(
            'explotations/index.html.twig',
            [
                'explotations' => $handledStamp->getResult(),
                'groups' => $handledS->getResult()
            ]
        );
    }
}
