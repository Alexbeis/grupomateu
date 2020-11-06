<?php

namespace Mateu\Backend\OutgoingRegister\Application\Create;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOutgoingRegisterCommandHandler implements MessageHandlerInterface
{
    /**
     * @var OutgoingRegisterCreator
     */
    private $outgoingRegisterCreator;

    public function __construct(OutgoingRegisterCreator $outgoingRegisterCreator)
    {
        $this->outgoingRegisterCreator = $outgoingRegisterCreator;
    }

    public function __invoke(CreateOutgoingRegisterCommand $createOutgoingRegisterCommand)
    {
        $this->outgoingRegisterCreator->create(
            $createOutgoingRegisterCommand->getExplotationCode(),
            $createOutgoingRegisterCommand->getUuid()
        );
    }
}