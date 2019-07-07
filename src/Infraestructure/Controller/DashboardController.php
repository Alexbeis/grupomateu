<?php

namespace Mateu\Infraestructure\Controller;

use Mateu\Domain\UseCases\Dashboard\SummaryDashboardUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DashboardController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractController
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/", name="index_dashboard")
     * @return Response
     */
    public function __invoke(SummaryDashboardUseCase $summaryDashboard)
    {
        $totals = $summaryDashboard->execute();

        return new Response(
            $this->render('dashboard/index.html.twig', [
                    'totals' => $totals
                ]
            )
        );

    }

}