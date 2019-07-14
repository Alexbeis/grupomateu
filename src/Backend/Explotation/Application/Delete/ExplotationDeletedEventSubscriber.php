<?php

namespace Mateu\Backend\Explotation\Application\Delete;

use Monolog\Logger;

class ExplotationDeletedEventSubscriber
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ExplotationDeleted $event)
    {
        $this->logger->info('CODE: ' . $event->getCode());
    }
}