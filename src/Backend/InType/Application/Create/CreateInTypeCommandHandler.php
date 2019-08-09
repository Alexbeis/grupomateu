<?php

namespace Mateu\Backend\InType\Application\Create;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateInTypeCommandHandler implements MessageHandlerInterface
{
    /**
     * @var InTypeCreator
     */
    private $creator;

    public function __construct(InTypeCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(CreateInTypeCommand $command)
    {
        $this->creator->create(
            $command->getUuid(),
            $command->getCode(),
            $command->getName()
        );
    }
}