<?php

namespace Mateu\Backend\Explotation\Application\Create;

class AddExplotationCommandHandler
{
    /**
     * @var ExplotationCreator
     */
    private $explotationCreator;

    public function __construct(ExplotationCreator $explotationCreator)
    {
        $this->explotationCreator = $explotationCreator;
    }

    public function handle(AddExplotationCommand $command)
    {
        $this->explotationCreator->create(
            $command->getCode(),
            $command->getName(),
            $command->getLocalization(),
            $command->getCreatedBy()
        );
    }

}