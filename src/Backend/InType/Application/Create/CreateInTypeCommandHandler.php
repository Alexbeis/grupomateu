<?php

namespace Mateu\Backend\InType\Application\Create;

class CreateInTypeCommandHandler
{
    /**
     * @var InTypeCreator
     */
    private $creator;

    public function __construct(InTypeCreator $creator)
    {
        $this->creator = $creator;
    }

    public function handle(CreateInTypeCommand $command)
    {
        $this->creator->create(
            $command->getUuid(),
            $command->getCode(),
            $command->getName()
        );
    }
}