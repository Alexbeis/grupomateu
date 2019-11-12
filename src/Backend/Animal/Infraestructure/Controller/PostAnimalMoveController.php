<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class PostAnimalMoveController extends BaseController implements ControllerInterface
{
    /**
     * @Route(
     *     "animals/move",
     *     name="move_animals",
     *     methods={"POST"}
     *     )
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        dd($request->request->all());
    }

}