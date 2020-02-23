<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Backend\Explotation\Application\GetAll\GetExplotationsQuery;
use Mateu\Backend\IncomingRegister\Application\Get\GetIncomingRegisterQuery;
use Mateu\Backend\InType\Application\GetAll\GetAllInTypes;
use Mateu\Backend\Supplier\Application\Get\GetSuppliersQuery;
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
class GetIncomingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @param Countries $countries
     * @param GetAllInTypes $inTypes
     * @param $uuid
     *
     * @return Response
     * @Route(
     *     {
     *     "es": "/registro-entrada/{uuid}",
     *     "en": "/incoming-register/{uuid}"
     * },
     *     name = "register_get",
     *     methods={"GET"}
     *     )
     */
    public function __invoke(Request $request, Countries $countries, GetAllInTypes $inTypes, string $uuid)
    {
        $registerEnvelope = $this->ask(
            new GetIncomingRegisterQuery($uuid)
        );
        $handled = $registerEnvelope->last(HandledStamp::class);

        $envelExpl = $this->ask(
            new GetExplotationsQuery()
        );
        $handledExpl = $envelExpl->last(HandledStamp::class);

        $envelSupp = $this->ask(
            new GetSuppliersQuery()
        );
        $handledSupp = $envelSupp->last(HandledStamp::class);

        return $this->render(
            'registers/register/index.html.twig',
            [
                'incomingRegister' => $handled->getResult(),
                "countries" => $countries->getList(),
                "inTypes" => $inTypes->get(),
                "explotations" => $handledExpl->getResult(),
                "suppliers" => $handledSupp->getResult()
            ]
        );

    }

}