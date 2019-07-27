<?php

namespace Mateu\Infraestructure\Controller\Configuration\Race;

use Mateu\Backend\Race\Application\Create\CreateRaceCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddRaceController
 * @package Mateu\Infraestructure\Controller\Configuration\Race
 * @IsGranted("ROLE_ADMIN")
 */
class AddRaceController extends BaseController
{
    /**
     * @param Request $request
     * @Route("configuration/race/add", name="add_race", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $this->dispatch(
                new CreateRaceCommand(
                    $request->get('race_code'),
                    $request->get('race_name')
                )
            );

        } catch (\Throwable $e) {
            $this->createFailResponse($e->getMessage());
        }

        return $this->createSuccessResponse('Raza creada correctamente');


    }

}