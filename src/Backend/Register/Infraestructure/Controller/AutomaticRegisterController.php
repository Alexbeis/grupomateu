<?php

namespace Mateu\Backend\Register\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewAutomaticRegisterController
 * @package Mateu\Backend\Register\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AutomaticRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/register/auto", name="register_auto", methods={"GET"})
     */
    public function __invoke()
    {
        return new Response(
            $this->render('registers/register/register-form.html.twig',[] )
        );

    }

}