<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Backend\IncomingRegister\Application\Create\CreateIncomingRegisterCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewAutomaticRegisterController
 * @package Mateu\Backend\Register\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class PostIncomingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse
     * @Route(
     *     {
     *     "es": "/registros-entrada/crear",
     *     "en": "/incoming-registers/create"
     * },
     *     name = "register_create",
     *     methods={"POST"}
     *     )
     *
     */
    public function __invoke(Request $request)
    {
        $data = $request->request->all();
        $uuid = Uuid::random();

        try {
            $this->dispatch(
                new CreateIncomingRegisterCommand(
                    $uuid->getValue(),
                    $data['inc_reg_intype'],
                    $data['inc_reg_procedence'],
                    $data['inc_reg_expl'],
                    $data['inc_reg_supplier'],
                    $data['inc_reg_guide_num'],
                    $data['inc_reg_guide_date'],
                    $data['inc_reg_expl_origin'],
                    $data['inc_reg_guide_total_animals']
                )
            );
        } catch (HandlerFailedException $e) {
            $this->get('session')->getFlashBag()->set('danger', $e->getMessage() );

            return $this->redirectToRoute("index_register");
        }

        return $this->redirectToRoute('register_get', ['uuid' => $uuid->getValue()]);
    }
}
