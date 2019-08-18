<?php

namespace Mateu\Backend\Group\Infraestructure\Controller;

use Mateu\Backend\Group\Application\Create\CreateGroupCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

class CreateGroupController extends BaseController implements  ControllerInterface
{
    /**
     * @Route("/group/add/", name="add_group", methods={"POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        try{
            $this->dispatch(
                new CreateGroupCommand(
                    $request->get('group_code'),
                    $request->get('group_name')
                )
            );

        } catch (HandlerFailedException $e) {
            dd($e->getMessage());
            $this->createFailResponse();
        }

        $this->get('session')->getFlashBag()->set('success', 'Grupo creado correctamente');

        return $this->redirectToRoute("index_explotations");
    }

}