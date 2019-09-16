<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use Mateu\Backend\Animal\Application\Save\SaveAnimalCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class SaveAnimalController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/animals/crotal/save", name="animal_save", methods={"POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        try{
            $params = $request->request->all();
            $this->dispatch(
                new SaveAnimalCommand(
                    $params['ani_id'],
                    $params['ani_intnum'],
                    $params['ani_crotal'],
                    $params['ani_crotal_mother'],
                    $params['ani_weight_in'],
                    $params['ani_weight_out'] ?:null,
                    $params['ani_birthdate'],
                    $params['ani_genre'],
                    $params['ani_race']
                )
            );
            $status = 'success';
            $message = 'Crotal guardado correctamente';

        } catch (HandlerFailedException $e) {
            $status = 'error';
            $message = $e->getMessage();
        }

        $this->get('session')->getFlashBag()->set($status, $message );
        return $this->redirectToRoute('edit_animal', ['id' => $params['ani_id']]);
    }
}