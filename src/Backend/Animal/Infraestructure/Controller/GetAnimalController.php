<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use Mateu\Backend\Animal\Application\GetAnimal\GetAnimalQuery;
use Mateu\Backend\Race\Application\Get\GetAllRaces;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class GetAnimalController extends BaseController implements ControllerInterface
{
    /**
     * @Route("/animals/crotal/{id}", name="edit_animal", methods={"GET"}, requirements={"id"= "\d+"})
     * @param $id
     * @param GetAllRaces $allRaces
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke($id, GetAllRaces $allRaces)
    {
        try{
            $envelope = $this->ask(new GetAnimalQuery($id));
            $handledStamp = $envelope->last(HandledStamp::class);

            return $this->render(
                'animals/animal/index-animal.html.twig',
                [
                    'animal' => $handledStamp->getResult(),
                    'races' => $allRaces->get()
                ]
            );
        } catch (HandlerFailedException $e){

        }

    }
}