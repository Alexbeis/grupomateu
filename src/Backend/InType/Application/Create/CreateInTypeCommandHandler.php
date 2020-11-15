<?php

namespace Mateu\Backend\InType\Application\Create;

use Assert\Assert;
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
        $uuid = $command->getUuid();
        $code = $command->getCode();
        $name = $command->getName();

        Assert::lazy()
            ->that($code, 'código')->string()->betweenLength(2, 50)
            ->that($name, 'Nombre')->string()->betweenLength(2, 50)
            ->verifyNow();

        $this->creator->create($uuid, $code, $name);
    }
}