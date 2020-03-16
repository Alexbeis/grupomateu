<?php

namespace Mateu\EventListener;

use Mateu\Shared\Serializer\SerializerFactory;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        $request  = $event->getRequest();
        
        if ($request->attributes->has('_format') && $request->attributes->get('_format') === 'csv') {
            $request->attributes->set(
                'serializer',
                SerializerFactory::create($request->attributes->get('_format'))
            );
        }
    }
}