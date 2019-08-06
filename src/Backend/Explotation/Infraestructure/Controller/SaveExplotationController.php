<?php

namespace Mateu\Backend\Explotation\Infraestructure\Controller;

use Exception;
use Mateu\Backend\Explotation\Application\Save\SaveExplotationCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SaveExplotationController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class SaveExplotationController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @Route("/explotation/save", name="save_explotation", methods={"POST"})
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $this->dispatch(
                new SaveExplotationCommand(
                    $request->get('exp_id'),
                    $request->get('exp_name'),
                    $request->get('exp_code'),
                    $request->get('exp_loca')
                )
            );

        } catch (Exception $e) {
            return $this->createFailResponse($e->getMessage());
        }

        return $this->createSuccessResponse('Guardada!');
    }

}