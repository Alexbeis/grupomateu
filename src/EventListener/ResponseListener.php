<?php

namespace Mateu\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        //var_dump($this->requestStack->getMasterRequest()->getRequestFormat());
        $response = $event->getResponse();

        //dd($response);
        
    }

}