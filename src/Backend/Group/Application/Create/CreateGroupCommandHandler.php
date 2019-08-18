<?php

namespace Mateu\Backend\Group\Application\Create;

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
        $this->creator->create($command->getCode(), $command->getName());
    }

}