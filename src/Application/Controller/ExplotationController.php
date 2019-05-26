<?php

namespace App\Application\Controller;


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
    public function index()
    {
        return $this->render('explotations/index.html.twig');

    }

}