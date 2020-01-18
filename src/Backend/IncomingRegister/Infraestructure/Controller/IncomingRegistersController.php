<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Backend\IncomingRegister\Application\Get\GetIncomingRegistersQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
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
     * @Route("/registers", name="index_register", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $envelope = $this->ask(new GetIncomingRegistersQuery());
        $handledStamp = $envelope->last(HandledStamp::class);

        return new Response(
            $this->render(
                'registers/index.html.twig',
                [
                    "registers" => $handledStamp->getResult()
                ]
            )
        );
    }
}
