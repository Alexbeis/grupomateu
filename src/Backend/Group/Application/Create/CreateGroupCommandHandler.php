<?php

namespace Mateu\Backend\Group\Application\Create;

use Assert\Assert;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateGroupCommandHandler implements MessageHandlerInterface
{
    /**
     * @var GroupCreator
     */
    private $creator;

    public function __construct(GroupCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(CreateGroupCommand $command)
    {
        $code = $command->getCode();
        $name = $command->getName();

        Assert::lazy()
            ->that($code, 'código')->string()->betweenLength(2, 10)
            ->that($name, 'Nombre')->string()->betweenLength(2, 50)
            ->verifyNow();

        $this->creator->create($code, $name);
    }
}
