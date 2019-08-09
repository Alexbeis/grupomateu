<?php

namespace Mateu\Backend\Input\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddInputsController
 * @package Mateu\Backend\Inputs\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AddInputsController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @Route( "input/new", name = "input_new", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        dd($request->get('entrance_app'));
    }
}
