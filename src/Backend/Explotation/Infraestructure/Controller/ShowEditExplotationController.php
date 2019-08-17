<?php

namespace Mateu\Backend\Explotation\Infraestructure\Controller;

use Mateu\Backend\Explotation\Application\Find\ExplotationFinder;
use Mateu\Backend\Group\Application\GetAll\GetAllGroupsQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShowEditExplotationController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class ShowEditExplotationController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/explotation/edit/{id}", name="edit_explotation", methods={"GET"}, requirements={"id"= "\d+"})
     * @param $id
     * @param ExplotationFinder $explotationFinder
     *
     * @return Response
     */
    public function __invoke($id, ExplotationFinder $explotationFinder)
    {
        try {
            // TODO: control exceptions from finder
            $explotation = $explotationFinder($id);

            $envelope = $this->ask(new GetAllGroupsQuery());
            $handledStamp = $envelope->last(HandledStamp::class);
        } catch (\Throwable $e) {

            $this->get('session')->getFlashBag()->set('danger', sprintf($e->getMessage()));
            return new RedirectResponse($this->router->generate('index_explotations'));
        }

        return new Response(
            $this->render('explotations/explotation/index.html.twig',
                [
                    'explotation' => $explotation,
                    'groups' => $handledStamp->getResult()
                ]
            )
        );
    }
}
