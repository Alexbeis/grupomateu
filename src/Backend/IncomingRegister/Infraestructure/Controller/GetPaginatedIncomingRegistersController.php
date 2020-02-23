<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Backend\IncomingRegister\Infraestructure\IncomingRegisterRepository;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewAutomaticRegisterController
 * @package Mateu\Backend\Register\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class GetPaginatedIncomingRegistersController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @param IncomingRegisterRepository $registerRepository
     *
     * @return JsonResponse
     * @Route(
     *     {
     *     "es": "/registros-entrada/paginados/",
     *     "en": "/incoming-registers/paginated/"
     * },
     *     name = "register_paginated",
     *     methods={"POST"}
     *     )
     *
     */
    public function __invoke(Request $request, IncomingRegisterRepository $registerRepository)
    {
        $data = $request->request->all();

        $result = $registerRepository->getPaginatedIncomingRegisters($data);

        foreach ($result['data'] as &$r) {
            $r['actions'] = $this->renderView(
                'registers/actions/dropdown-button.html.twig',
                [
                    'uuid' => $r['uuid']
                ]
            );
        }

        return new JsonResponse($result);
    }
}