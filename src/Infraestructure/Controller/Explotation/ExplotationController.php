<?php

namespace Mateu\Infraestructure\Controller\Explotation;

use Mateu\Backend\Explotation\Application\Delete\NotEmptyExplotationException;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Infraestructure\Controller\BaseController;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Application\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class ExplotationController extends BaseController
{
    /**
     * @Route("/explotations" ,name="index_explotations")
     */
    public function index(ContainerInterface $container)
    {
        $allExplotationsUseCase = $container->get('usecases.get.all.explotations');

        return $this->render(
            'explotations/index.html.twig', [
            'explotations' => $allExplotationsUseCase->execute()
        ]
        );
    }

    /**
     * @Route("/explotation/edit/{id}", name="edit_explotation")
     *
     */
    public function edit(Explotation $explotation)
    {


        return new Response('ok');
    }


    public function remove(Explotation $explotation)
    {
        try {
            $removeExplotation = $this->container->get('usecases.delete.explotation');
            $removeExplotation->execute($explotation);

            return new JsonResponse(
                [
                    'success' => true,
                    'message' => 'Explotación borrada correctamente'
                ]
            );
        } catch (NotEmptyExplotationException $e) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => $e->getMessage()
                ]
            );
        } catch (Exception $e) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => $e->getMessage()
                ]
            );
        }

    }

}