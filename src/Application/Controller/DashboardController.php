<?php

namespace App\Application\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="index_dashboard")
     */
    public function index()
    {

        return new Response($this->render('base.html.twig'));

    }

}