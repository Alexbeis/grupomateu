<?php

namespace Mateu\Backend\History\Application\Create;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateHistoryCommandHandler implements MessageHandlerInterface
{
    /**
     * @var HistoryCreator
     */
    private $historyCreator;

    public function __construct(HistoryCreator $historyCreator)
    {

        $this->historyCreator = $historyCreator;
    }

    public function __invoke(CreateHistoryCommand $command)
    {
        $this->historyCreator->create($command->getAnimalId(), $command->getComment());
    }

}