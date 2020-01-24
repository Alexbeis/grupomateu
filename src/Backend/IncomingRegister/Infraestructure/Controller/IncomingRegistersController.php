<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Backend\Explotation\Application\GetAll\GetExplotationsQuery;
use Mateu\Backend\IncomingRegister\Application\Get\GetIncomingRegistersQuery;
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
 * Class IncomingRegistersController
 * @package Mateu\Backend\IncomingRegister\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class IncomingRegistersController extends BaseController implements ControllerInterface
{
    /**
     * @Route({
     *     "es": "/registros-entrada",
     *     "en": "/incoming-registers"
     * },
     *     name="index_register", methods={"GET"})
     * @param Request $request
     *
     * @param Countries $countries
     *
     * @param GetAllInTypes $inTypes
     *
     * @return Response
     */
    public function __invoke(Request $request, Countries $countries, GetAllInTypes $inTypes)
    {
        $envelRegister = $this->ask(new GetIncomingRegistersQuery());
        $handledRegister = $envelRegister->last(HandledStamp::class);

        $envelExpl = $this->ask(new GetExplotationsQuery());
        $handledExpl = $envelExpl->last(HandledStamp::class);

        $envelSupp = $this->ask(new GetSuppliersQuery());
        $handledSupp = $envelSupp->last(HandledStamp::class);

        return new Response(
            $this->render(
                'registers/index.html.twig',
                [
                    "registers" => $handledRegister->getResult(),
                    "countries" => $countries->getList(),
                    "inTypes" => $inTypes->get(),
                    "explotations" => $handledExpl->getResult(),
                    "suppliers" => $handledSupp->getResult()
                ]
            )
        );
    }
}
