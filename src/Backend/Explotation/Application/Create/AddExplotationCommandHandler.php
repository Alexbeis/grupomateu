<?php

namespace Mateu\Backend\Explotation\Application\Create;

use Mateu\Backend\Explotation\Domain\ExplotationCode;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddExplotationCommandHandler implements MessageHandlerInterface
{
    /**
     * @var ExplotationCreator
     */
    private $explotationCreator;

    public function __construct(ExplotationCreator $explotationCreator)
    {
        $this->explotationCreator = $explotationCreator;
    }

    public function __invoke(AddExplotationCommand $command)
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