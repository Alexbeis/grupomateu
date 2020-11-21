<?php

namespace Mateu\Backend\IncomingRegister\Application\Create;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateIncomingRegisterCommandHandler implements MessageHandlerInterface
{
    /**
     * @var IncomingRegisterCreator
     */
    private $incomingRegisterCreator;

    public function __construct(IncomingRegisterCreator $incomingRegisterCreator)
    {
        $this->incomingRegisterCreator = $incomingRegisterCreator;
    }

    public function __invoke(CreateIncomingRegisterCommand $incomingRegisterCommand)
    {
        $this
            ->incomingRegisterCreator
            ->create(
                $incomingRegisterCommand->getUuid(),
                $incomingRegisterCommand->getInTypeId(),
                $incomingRegisterCommand->getProcedende(),
                $incomingRegisterCommand->getExplotationId(),
                $incomingRegisterCommand->getSupplierId(),
                $incomingRegisterCommand->getGuideNum(),
                $incomingRegisterCommand->getGuideDate(),
                $incomingRegisterCommand->getOrigin(),
                $incomingRegisterCommand->getTotalGuideAnimals(),
            );
    }
}