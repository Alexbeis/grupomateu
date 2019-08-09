<?php

namespace Mateu\Backend\Input\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InputController
 * @package Mateu\Backend\Input\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class InputController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/entrance", name="index_entrance", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return new Response(
            $this->render('entrance/index.html.twig')
        );
    }
}