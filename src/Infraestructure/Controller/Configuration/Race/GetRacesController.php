<?php

namespace Mateu\Infraestructure\Controller\Configuration\Race;

use Mateu\Infraestructure\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class GetRacesController
 * @package Mateu\Infraestructure\Controller\Configuration\Race
 * @IsGranted("ROLE_ADMIN")
 */
class GetRacesController extends BaseController
{
    /**
     * @return JsonResponse
     * @Route("configuration/races/get", name="races_get")
     */
    public function __invoke()
    {
        return new JsonResponse('HELLO');
    }

}