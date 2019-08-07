<?php

namespace Mateu\Infraestructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;

class BaseController extends AbstractController
{
    /**
     * @var MessageBus
     */
    protected $commandBus;

    /**
     * @var MessageBusInterface
     */
    private $queryBus;

    /**
     * @var RouterInterface
     */
    protected $router;

    public function __construct(MessageBusInterface $commandBus, MessageBusInterface $queryBus,  RouterInterface $router)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->router = $router;
    }

    protected function dispatch($command)
    {
        $this->commandBus->dispatch($command);
    }

    protected function ask($query)
    {
        return $this->queryBus->dispatch($query);
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