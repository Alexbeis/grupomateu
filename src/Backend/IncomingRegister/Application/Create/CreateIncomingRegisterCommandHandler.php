<?php

namespace Mateu\Backend\IncomingRegister\Application\Create;

use Assert\Assert;
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
        $uuid = $incomingRegisterCommand->getUuid();
        $inTypeId = (int)$incomingRegisterCommand->getInTypeId();
        $procedence = $incomingRegisterCommand->getProcedende();
        $explotationId = (int)$incomingRegisterCommand->getExplotationId();
        $supplierId = (int)$incomingRegisterCommand->getSupplierId();
        $guideNum = $incomingRegisterCommand->getGuideNum();
        $guideDate = $incomingRegisterCommand->getGuideDate();
        $origin = $incomingRegisterCommand->getOrigin();

        Assert::lazy()
            ->that($uuid,'uuid')->uuid()
            ->that($inTypeId, 'Id tipo entrada')->integer()
            ->that($procedence, 'Procedencia')->nullOr()->string()->betweenLength(0, 50)
            ->that($explotationId, ' Id explotación')->integer()
            ->that($supplierId, 'Id proveedor')->nullOr()->integer()
            ->that($guideNum, 'Guia Entrada')->nullOr()->string()->betweenLength(0, 50)
            ->that($guideDate, 'Fecha Guia')->nullOr()->string()
            ->that($origin, 'Explotacion Origen')->nullOr()->string()->betweenLength(0, 50)
            ->verifyNow();
        $this
            ->incomingRegisterCreator
            ->create(
                $uuid,
                $inTypeId,
                $procedence,
                $explotationId,
                $supplierId,
                $guideNum,
                $guideDate,
                $origin
            );
    }
}