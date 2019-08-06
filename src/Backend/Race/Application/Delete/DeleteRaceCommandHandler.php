<?php

namespace Mateu\Backend\Race\Application\Delete;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteRaceCommandHandler implements MessageHandlerInterface
{
    /**
     * @var RaceDeletor
     */
    private $raceDeletor;

    public function __construct(RaceDeletor $raceDeletor)
    {
        $this->raceDeletor = $raceDeletor;
    }

    public function __invoke(DeleteRaceCommand $command)
    {
        $this->raceDeletor->delete($command->getId());
    }
}
