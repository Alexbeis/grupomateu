<?php

namespace Mateu\Infraestructure\Controller;

use Psr\Container\ContainerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;

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
    /**
     * @var RouterInterface
     */
    protected $router;

    public function __construct(MessageBusInterface $bus, ContainerInterface $container, RouterInterface $router)
    {
        $this->bus = $bus;
        $this->container = $container;
        $this->router = $router;
    }

    protected function dispatch($command)
    {
        $this->bus->dispatch($command);
    }

    protected function createSuccessResponse($message = null, $params = null)
    {
        return $this->createJsonResponse(true, $message, $params);
    }

    protected function createFailResponse($message = null)
    {
        return $this->createJsonResponse(false, $message);
    }

    private function createJsonResponse($sucess, $message, $params = null)
    {
        return new JsonResponse(
            [
                'success' => $sucess,
                'message' => $message,
                'params' => $params
            ]
        );

    }



}