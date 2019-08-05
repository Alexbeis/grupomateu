<?php

namespace Mateu\Backend\Race\Infraestructure\Controller;

use Mateu\Backend\Race\Application\Delete\DeleteRaceCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteRaceController
 * @package Mateu\Infraestructure\Controller\Configuration\Race
 * @IsGranted("ROLE_ADMIN")
 */
class DeleteRaceController extends BaseController
{
    /**
     * @param Request $request
     * @Route("configuration/race/delete", name="delete_race", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $this->dispatch(
                new DeleteRaceCommand(
                    $request->get('race_id')
                )
            );

        } catch (\Throwable $e) {
            $this->createFailResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->createFailResponse($e->getMessage());

        }

        return $this->createSuccessResponse('Raza Eliminada correctamente');


    }

}