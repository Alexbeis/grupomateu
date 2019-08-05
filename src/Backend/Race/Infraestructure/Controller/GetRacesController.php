<?php

namespace Mateu\Backend\Race\Infraestructure\Controller;

use Mateu\Backend\Race\Application\Get\GetAllRaces;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class GetRacesController
 * @package Mateu\Infraestructure\Controller\Configuration\Race
 * @IsGranted("ROLE_ADMIN")
 */
class GetRacesController extends BaseController implements ControllerInterface
{
    /**
     * @return JsonResponse
     * @Route("configuration/races/get", name="races_get", methods={"GET"})
     */
    public function __invoke(GetAllRaces $allRaces)
    {
        return new JsonResponse(
            $allRaces->get()
        );
    }
}
