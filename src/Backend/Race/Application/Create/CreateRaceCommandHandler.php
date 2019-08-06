<?php

namespace Mateu\Backend\Race\Application\Create;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateRaceCommandHandler implements MessageHandlerInterface
{
    /**
     * @var RaceCreator
     */
    private $creator;

    public function __construct(RaceCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(CreateRaceCommand $command)
    {
        $uuid = $command->getUuid();
        $code = $command->getCode();
        $name = $command->getName();

        $this->creator->create($uuid,$code, $name);
    }
}