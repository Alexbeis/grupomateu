<?php

namespace Mateu\Backend\Animal\Infraestructure\Controller;

use Mateu\Backend\Animal\Application\GetAll\GetAnimalsQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetAnimalsController
 * @package Mateu\Backend\Animal\Infraestructure
 * @IsGranted("ROLE_ADMIN")
 */
class GetAnimalsController extends BaseController
{
    /**
     * @Route("animals", name="index_animals")
     */
    public function __invoke()
    {
        $envelope = $this->ask(new GetAnimalsQuery());
        $handledStamp = $envelope->last(HandledStamp::class);

        return new Response(
            $this->render(
                'animals/index.html.twig',
                ['animals' => $handledStamp->getResult()]
            )
        );
    }
}