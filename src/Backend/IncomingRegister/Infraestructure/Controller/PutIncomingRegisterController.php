<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Backend\IncomingRegister\Application\Save\SaveIncomingRegisterCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PutIncomingRegisterController
 * @package Mateu\Backend\Register\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class PutIncomingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse
     * @Route(
     *     {
     *     "es": "/registros/entrada/guardar",
     *     "en": "/incoming/registers/save"
     * },
     *     name = "register_save",
     *     methods={"PUT"}
     * )
     */
    public function __invoke(Request $request)
    {
        $data = $request->request->all();

        try {
            $this->dispatch(
                new SaveIncomingRegisterCommand(
                    $data['inc_reg_id'],
                    $data['inc_reg_expl'],
                    $data['inc_reg_procedence'],
                    $data['inc_reg_intype'],
                    $data['inc_reg_supplier'],
                    $data['inc_reg_guide_num'],
                    $data['inc_reg_guide_date'],
                    $data['inc_reg_expl_origin']
                )
            );
        } catch (HandlerFailedException $e) {
            $this->get('session')->getFlashBag()->set('danger', $e->getMessage() );

            return $this->redirectToRoute("index_register");
        }

        $this->get('session')->getFlashBag()->set('success', 'Registro guardado correctamente');
        return $this->redirectToRoute('register_get', ['uuid' => $data['inc_reg_uuid']]);
    }
}