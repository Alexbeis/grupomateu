<?php

namespace Mateu\Backend\Register\Infraestructure\Controller;

use Mateu\Backend\Register\Application\Get\GetRegistersQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterController
 * @package Mateu\Backend\Register\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class RegisterController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/registers", name="index_register", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $envelope = $this->ask(new GetRegistersQuery());
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
