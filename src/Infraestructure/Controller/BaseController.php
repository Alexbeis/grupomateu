<?php

namespace Mateu\Infraestructure\Controller;

use Psr\Container\ContainerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    /**
     * @var CommandBus
     */
    protected $bus;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(CommandBus $bus, ContainerInterface $container)
    {
        $this->bus = $bus;
        $this->container = $container;
    }

    public function dispatch($command)
    {
        $this->bus->handle($command);
    }

}