<?php

namespace Mateu\Backend\Annex\Infraestructure\Controller;

use Mateu\Backend\Annex\Application\BulkDelete\BulkDeleteCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@IsGranted("ROLE_ADMIN")
 */
class BulkDeleteController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @Route({
     *     "en":"/annex/delete/bulk",
     *     "es": "marcado/eliminar/massivo"
     * },
     *     name="annex_bulk_delete",
     *     methods={"DELETE"},
     *     options = { "expose" = true })
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $expCode = $request->get('exp_code');

        try {
            $this->dispatch(
                new BulkDeleteCommand($expCode)
            );
        } catch (\Exception $e){
            return $this->createFailResponse($e->getMessage());
        }

        return $this->createSuccessResponse('Animales Desmarcados correctamente');
    }
}
