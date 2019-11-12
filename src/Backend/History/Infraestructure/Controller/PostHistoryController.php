<?php

namespace Mateu\Backend\History\Infraestructure\Controller;

use Mateu\Backend\History\Application\Create\CreateHistoryCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class PostHistoryController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/history/create", name="history_create", methods={"POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $this->dispatch(
                new CreateHistoryCommand(
                    $request->request->get('ani_id'),
                    $request->request->get('ani_hist')
                )
            );

            $this->get('session')->getFlashBag()->set('success', 'Historia Creada correctamente.' );


        } catch (HandlerFailedException $e) {
            $this->get('session')->getFlashBag()->set('danger', $e->getMessage());
        }
        return $this->redirectToRoute("edit_animal", ['id' => $request->request->get('ani_id')]);

    }

}