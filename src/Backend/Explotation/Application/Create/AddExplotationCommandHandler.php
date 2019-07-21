<?php

namespace Mateu\Backend\Explotation\Application\Create;

use Mateu\Backend\Explotation\Domain\ExplotationCode;

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
        $code = new ExplotationCode($command->getCode());

        $this->explotationCreator->create(
            $code->getCode(),
            $command->getName(),
            $command->getLocalization(),
            $command->getCreatedBy()
        );
    }

}