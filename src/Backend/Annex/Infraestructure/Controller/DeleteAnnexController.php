<?php

namespace Mateu\Backend\Annex\Infraestructure\Controller;

use Mateu\Backend\Annex\Application\Delete\DeleteAnnexCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@IsGranted("ROLE_ADMIN")
 */
class DeleteAnnexController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @Route({
     *     "en":"/annex/delete",
     *     "es": "marcado/eliminar"
     * },
     *     name="annex_delete",
     *     methods={"DELETE"},
     *     options = { "expose" = true })
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try{
            $this->dispatch(
                new DeleteAnnexCommand(
                    $request->request->get('id')
                )
            );

            return $this->createSuccessResponse('Animal Desmarcado.');

        } catch (HandlerFailedException $e) {
            return $this->createFailResponse($e->getMessage());
        }
    }

}