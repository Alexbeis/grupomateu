<?php

namespace Mateu\Infraestructure\Controller\Explotation;

use Mateu\Backend\Explotation\Application\Create\AddExplotationCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AddExplotationController extends AbstractController
{
    /**
     * @var MessageBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/explotation/add/", name="add_explotation", methods={"POST", "GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $this->commandBus->handle(
            new AddExplotationCommand('CODE_15', 'Command', 'loc32974269438', $this->getUser())
        );

        $this->get('session')->getFlashBag()->set('success', 'Explotación creada correctamente');

        return $this->redirectToRoute("index_explotations");
    }

}