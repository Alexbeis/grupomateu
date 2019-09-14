<?php

namespace Mateu\Backend\Annex\Application\Delete;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteAnnexCommandHandler implements MessageHandlerInterface
{
    private $annexDeletor;

    public function __construct(AnnexDeletor $annexDeletor)
    {
        $this->annexDeletor = $annexDeletor;
    }

    public function __invoke(DeleteAnnexCommand $command)
    {
        $this->annexDeletor->delete($command->getAnimalId());
    }

}