<?php

namespace Mateu\Backend\Explotation\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
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
    public function __invoke(ContainerInterface $container)
    {
        $allExplotationsUseCase = $container->get('usecases.get.all.explotations');

        return $this->render(
            'explotations/index.html.twig',
            [
                'explotations' => $allExplotationsUseCase->execute()
            ]
        );
    }
}