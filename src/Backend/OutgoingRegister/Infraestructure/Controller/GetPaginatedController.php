<?php

namespace Mateu\Backend\OutgoingRegister\Infraestructure\Controller;

use Mateu\Backend\OutgoingRegister\Infraestructure\OutgoingRegisterRepository;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetPaginatedController
 * @package Mateu\Backend\OutgoingRegister\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class GetPaginatedController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @param OutgoingRegisterRepository $outgoingRegisterRepository
     *
     * @return JsonResponse
     * @Route(
     *     {
     *     "es": "/registros-salida/paginados/",
     *     "en": "/outgoing-registers/paginated/"
     *      },
     *     name = "out_register_paginated",
     *     methods={"POST"}
     *     )
     */
    public function __invoke(Request $request, OutgoingRegisterRepository $outgoingRegisterRepository)
    {
        $data = $request->request->all();

        $result = $outgoingRegisterRepository->getPaginatedOutgoingRegisters($data);

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