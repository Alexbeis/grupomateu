<?php

namespace Mateu\Backend\Race\Application\Delete;

class DeleteRaceCommandHandler
{
    /**
     * @var RaceDeletor
     */
    private $raceDeletor;

    public function __construct(RaceDeletor $raceDeletor)
    {
        $this->raceDeletor = $raceDeletor;
    }

    public function handle(DeleteRaceCommand $command)
    {
        $this->raceDeletor->delete($command->getId());
    }
}
