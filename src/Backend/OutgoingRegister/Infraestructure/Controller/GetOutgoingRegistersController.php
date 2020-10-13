<?php

namespace Mateu\Backend\OutgoingRegister\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetOutgoingRegistersController
 * @IsGranted("ROLE_ADMIN")
 */
class GetOutgoingRegistersController extends BaseController implements ControllerInterface
{
    /**
     * @Route(
        {
     *     "es": "/registros-salida/",
     *     "en": "/out-registers/"
     * },
     *     name="index_outregisters", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return new Response($this->renderView('outregisters/index.html.twig'));
    }
}