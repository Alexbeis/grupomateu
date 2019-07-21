<?php

namespace Mateu\Infraestructure\Controller\Explotation;

use Mateu\Infraestructure\Controller\BaseController;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AllExplotationsController
 * @IsGranted("ROLE_ADMIN")
 */
class AllExplotationsController extends BaseController
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