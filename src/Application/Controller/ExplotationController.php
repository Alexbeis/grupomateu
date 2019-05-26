<?php

namespace App\Application\Controller;


use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Application\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class ExplotationController extends AbstractController
{

    /**
     * @Route("/explotations" ,name="index_explotations")
     */
    public function index(ContainerInterface $container)
    {
        $allExplotationsUseCase = $container->get('application.usecases.get.all.explotations');

        return $this->render(
            'explotations/index.html.twig',
            [
                'explotations' => $allExplotationsUseCase->execute()
            ]
        );

    }

}