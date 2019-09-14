<?php

namespace Mateu\Backend\Annex\Application\Create;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateAnnexCommandHandler implements MessageHandlerInterface
{
    private $creator;

    public function __construct(AnnexCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(CreateAnnexCommand $command)
    {
        $this->creator->create($command->getAnimalId());
    }
}
