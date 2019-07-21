<?php

namespace Mateu\Infraestructure\Controller\Explotation;

use Mateu\Backend\Explotation\Application\Save\SaveExplotationCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SaveExplotationController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class SaveExplotationController extends BaseController
{
    /**
     * @param Request $request
     * @Route("/explotation/save", name="save_explotation", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $this->dispatch(
            new SaveExplotationCommand(
                $request->get('exp_id'),
                $request->get('exp_name'),
                $request->get('exp_code'),
                $request->get('exp_loca')
            )
        );

        return new Response('ok');
    }

}