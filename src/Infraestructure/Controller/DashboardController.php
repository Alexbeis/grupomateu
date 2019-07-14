<?php

namespace Mateu\Infraestructure\Controller;

use Mateu\Domain\UseCases\Dashboard\SummaryDashboardUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends BaseController
{
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