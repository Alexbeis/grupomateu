<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use Mateu\Backend\Animal\Application\Move\MoveAnimalCommand;
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
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $explotationTo = $request->request->get('expl_to');
        $animals = $request->request->get('animals');
        $explotationFrom = $request->request->get('expl_from');
        $this->commandBus->dispatch(
            new MoveAnimalCommand(
                $explotationTo,
                $animals
            )
        );
        $this->get('session')->getFlashBag()->set('success', 'Animales movidos correctamente' );

        return $this->redirectToRoute('edit_explotation', ['id' => $explotationFrom ]);
    }

}