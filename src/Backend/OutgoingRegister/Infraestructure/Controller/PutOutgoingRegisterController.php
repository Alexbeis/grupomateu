<?php

namespace Mateu\Backend\OutgoingRegister\Infraestructure\Controller;

use Mateu\Backend\OutgoingRegister\Application\Save\OutGoingRegisterSaver;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostOutgoingRegisterController
 * @IsGranted("ROLE_ADMIN")
 */
class PutOutgoingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     *
     * @return Response
     * @Route(
     *     {
     *     "en": "/outgoing-registers/save/",
     *      "es": "/registros-salida/guardar/",
     *      },
     *     name = "out_register_save",
     *     methods={"PUT"}
     *     )
     */
    public function __invoke(Request $request, OutGoingRegisterSaver $saver)
    {
        try {
            $data = $request->request->all();
            $saver->save($data);

            $this->get('session')->getFlashBag()->set('success', 'Registro guardado correctamente');

            return $this->redirectToRoute('out_register_get', ['uuid' => $data['out_reg_uuid']]);

        } catch (\Exception $e) {

            $this->get('session')->getFlashBag()->set('danger', $e->getMessage() );

            return $this->redirectToRoute('out_register_get', ['uuid' => $data['out_reg_uuid']]);
        }
    }
}