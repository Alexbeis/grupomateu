<?php

namespace Mateu\Backend\OutgoingRegister\Infraestructure\Controller;

use Mateu\Backend\Explotation\Application\GetAll\GetExplotationsQuery;
use Mateu\Backend\OutgoingRegister\Application\Get\GetOutgoingRegisterQuery;
use Mateu\Backend\OutType\Application\GetAll\GetAllOutTypes;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Mateu\Shared\Domain\Countries\Countries;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetIncomingRegisterController
 * @package Mateu\Backend\Register\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class GetOutgoingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @param Countries $countries
     * @param GetAllOutTypes $allOutTypes
     * @param string $uuid
     *
     * @return Response
     * @Route(
     *     {
     *     "es": "/registros/salida/{uuid}",
     *     "en": "/registers/outgoing/{uuid}"
     * },
     *     name = "out_register_get",
     *     methods={"GET"}
     *     )
     */
    public function __invoke(Request $request, Countries $countries, GetAllOutTypes $allOutTypes, string $uuid)
    {
        $envelope= $this->ask(
            new GetOutgoingRegisterQuery($uuid)
        );

        $handled = $envelope->last(HandledStamp::class);

        $envelExpl = $this->ask(
            new GetExplotationsQuery()
        );
        $handledExpl = $envelExpl->last(HandledStamp::class);


        return new Response(
            $this->renderView(
                'outregisters/outregister/index.html.twig',
                [
                    'outregister' => $handled->getResult(),
                    'explotations' => $handledExpl->getResult(),
                    'outTypes' => $allOutTypes->get(),
                    'countries' => $countries->getList()
                ]
            )
        );
    }
}
