<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Exception;
use Mateu\Backend\IncomingRegister\Application\AddAnimal\AddAnimalCommand;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AutomaticIncomingRegisterController
 * @package Mateu\Backend\IncomingRegister\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AutomaticIncomingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/incoming-register/crotal/auto-add",
     *     name="incoming_register_auto_add",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @param IncomingRegisterRepositoryInterface $incomingRegisterRepository
     *
     * @return Response
     * @throws Exception
     */
    public function __invoke(Request $request, IncomingRegisterRepositoryInterface $incomingRegisterRepository)
    {
        $entrance = $request->request->get('entrance_path');
        $id = $request->request->get('inc_reg_id');
        $uuid = $request->request->get('inc_reg_uuid');

        try {
            $this->dispatch(
                new AddAnimalCommand(
                    $id,
                    $entrance
                )
            );

        } catch (HandlerFailedException $e) {
            $this->get('session')->getFlashBag()->set('danger', $e->getMessage());

            return $this->redirectToRoute('register_get', ['uuid' => $uuid]);
        }

        $this->get('session')->getFlashBag()->set('success', 'Animal añadido  correctamente');

        return $this->redirectToRoute('register_get', ['uuid' => $uuid]);
    }
}