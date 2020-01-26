<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AutomaticIncomingRegisterController
 * @package Mateu\Backend\IncomingRegister\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AutomaticIncomingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/register/auto", name="register_auto", methods={"GET"})
     */
    public function __invoke()
    {
        return new Response(
            $this->render('register-animal-form.html.twig',[] )
        );

    }

}