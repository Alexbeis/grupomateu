<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class DeleteAnimalSupressionController extends BaseController implements  ControllerInterface
{
    /**
     * @Route(
     *     "animals/crotal/supression/{animalId}/delete",
     *     name="animal_supression_delete",
     *     methods={"GET"}
     *     )
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function __invoke(Request $request, $animalId)
    {
        $animalRepo = $this->getDoctrine()->getRepository(Animal::class);

        $animal=$animalRepo->find($animalId);
        $animal->setSupression(null);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('edit_animal', ['id' => $animalId]);

    }

}