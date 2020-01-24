<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use function MongoDB\BSON\toJSON;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewAutomaticRegisterController
 * @package Mateu\Backend\Register\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class PostIncomingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @Route(
     *     {
     *     "es": "/registros-entrada/crear",
     *     "en": "/incoming-registers/create"
     * },
     *     name = "register_create",
     *     methods={"POST"}
     *     )
     */
    public function __invoke(Request $request)
    {
        dd($request->request->all());

        //return new JsonResponse(['data' => true]);
    }
}
