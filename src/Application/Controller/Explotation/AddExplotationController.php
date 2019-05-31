<?php

namespace App\Application\Controller\Explotation;

use App\Domain\Command\Explotation\AddExplotationCommand;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddExplotationController extends AbstractController
{
    /**
     * @var CommandBus
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
    public function add(Request $request)
    {
        $this->commandBus->handle(
            new AddExplotationCommand('CODE_15', 'Command', 'loc32974269438', $this->getUser())
        );

        $this->get('session')->getFlashBag()->set('success', 'Explotación creada correctamente');

        return $this->redirectToRoute("index_explotations");
    }

    public function new()
    {

    }

}