<?php

namespace Mateu\Backend\IncomingRegister\Application\Save;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SaveIncomingRegisterCommandHandler implements MessageHandlerInterface
{
    /**
     * @var IncomingRegisterInfoSaver
     */
    private $saver;

    public function __construct(IncomingRegisterInfoSaver $saver)
    {
        $this->saver = $saver;
    }

    public function __invoke(SaveIncomingRegisterCommand $saveIncomingRegisterCommand)
    {
        $this->saver->execute(
            $saveIncomingRegisterCommand->getId(),
            $saveIncomingRegisterCommand->getExplotationId(),
            $saveIncomingRegisterCommand->getProcedenceCode(),
            $saveIncomingRegisterCommand->getInTypeId(),
            $saveIncomingRegisterCommand->getSupplierId()
        );
    }
}