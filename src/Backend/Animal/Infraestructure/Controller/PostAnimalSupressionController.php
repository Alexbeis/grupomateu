<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use DateTime;
use Mateu\Backend\Animal\Application\PostSupression\PostAnimalSupressionCommand;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Animal\Domain\Entity\Supression;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        $data = $request->request->all();

        $this->dispatch(
            new PostAnimalSupressionCommand(
                $data['sup_animal'],
                $data['sup_days'],
                $data['sup_product'],
                $data['sup_date']
            )
        );

        return $this->redirectToRoute('edit_animal', ['id' => $data['sup_animal']]);

    }

}