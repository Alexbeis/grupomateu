<?php

namespace App\Application\Controller;


use App\Domain\Entity\Explotation;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/explotation/edit/{id}", name="edit_explotation")
     */
    public function edit(Explotation $explotation)
    {
        dd($explotation);

        return new Response('ok');
    }

}