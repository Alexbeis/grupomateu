<?php

namespace Mateu\Infraestructure\Controller\Explotation;


use Mateu\Domain\Exception\Explotation\NotEmptyExplotationException;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
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
class ExplotationController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

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

    /**
     * @param Explotation $explotation
     * @param ContainerInterface $container
     * @Route("/explotation/remove/{id}", name="remove_explotation", requirements={"id"= "\d+"},
     *                                    methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function remove(Explotation $explotation, ContainerInterface $container)
    {
        try {
            $removeExplotation = $container->get('usecases.delete.explotation');
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