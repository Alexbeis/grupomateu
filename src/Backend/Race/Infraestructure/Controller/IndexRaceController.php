<?php

namespace Mateu\Backend\Race\Infraestructure\Controller;

use Mateu\Backend\Race\Application\Get\GetAllRaces;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexRaceController
 * @package Mateu\Backend\Race\Infraestructure\Controller;

 * @IsGranted("ROLE_ADMIN")
 */
class IndexRaceController extends BaseController
{
    /**
     * @Route("configuration/races/", name="index_race", methods={"GET"})
     * @param GetAllRaces $allRaces
     *
     * @return Response
     */
    public function __invoke(GetAllRaces $allRaces)
    {
        return new Response(
            $this->render(
                'configuration/race/race-box.html.twig',
                [
                    'races' => $allRaces->get()
                ]
            )
        );
    }
}