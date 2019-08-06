<?php

namespace Mateu\Backend\Notification\Application\Create;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NotificationCommandHandler implements MessageHandlerInterface
{
    public function __invoke(NotificationCommand $command)
    {
        foreach ($command->getUser() as $user) {
            echo 'Notificación para:' . $user . ':' . $command->getMessage();
        }
    }
}