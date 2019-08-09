<?php

namespace Mateu\Backend\Explotation\Application\Delete\Event;

use Mateu\Backend\Explotation\Application\Delete\ExplotationDeleted;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ExplotationDeletedEventHandler implements MessageHandlerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ExplotationDeleted $event)
    {
        $this->logger->debug(sprintf('Explotation (%s) deleted successfully by %s', $event->getCode(), $event->getCreatedBy()->getUserName()));
    }
}