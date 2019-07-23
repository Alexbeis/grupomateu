<?php

namespace Mateu\Infraestructure\Controller\Explotation;

use Mateu\Backend\Explotation\Application\Create\AddExplotationCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExplotationController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AddExplotationController extends BaseController
{
    /**
     * @Route("/explotation/add/", name="add_explotation", methods={"POST", "GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $this->bus->handle(
                new AddExplotationCommand(
                    $request->get('exp_code'),
                    $request->get('exp_name'),
                    null,
                    $this->getUser())
            );
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->set('error', $e->getMessage() );

            return $this->redirectToRoute("index_explotations");
        }

        $this->get('session')->getFlashBag()->set('success', 'Explotación creada correctamente');

        return $this->redirectToRoute("index_explotations");
    }

}