<?php

namespace App\Application\Controller;

use App\Domain\UseCases\Dashboard\SummaryDashboardUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DashboardController
 * @package App\Application\Controller
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
     * @Route("/", name="index")
     */
    public function index()
    {
        if ($this->getUser()) {
            return new RedirectResponse($this->router->generate('index_dashboard'));
        }
    }

    /**
     * @Route("/admin", name="index_dashboard")
     */
    public function dashboard(SummaryDashboardUseCase $summaryDashboard)
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