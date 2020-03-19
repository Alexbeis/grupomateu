<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use Exception;
use Mateu\Backend\Animal\Application\PostSupression\PostAnimalSupressionCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class PostAnimalSupressionController extends BaseController implements ControllerInterface
{
    /**
     * @Route(
     *     "animals/crotal/supression",
     *     name="animal_supression",
     *     methods={"POST"}
     *     )
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        $data = $request->request->all();

        try {
            $this->dispatch(
                new PostAnimalSupressionCommand(
                    $data['sup_animal'],
                    $data['sup_days'],
                    $data['sup_product'],
                    $data['sup_date']
                )
            );

        } catch (HandlerFailedException $exception) {

        }

        return $this->redirectToRoute('edit_animal', ['id' => $data['sup_animal']]);
    }
}
