<?php

namespace Mateu\Backend\Race\Application\Create;

class CreateRaceCommandHandler
{
    /**
     * @var RaceCreator
     */
    private $creator;

    public function __construct(RaceCreator $creator)
    {
        $this->creator = $creator;
    }

    public function handle(CreateRaceCommand $command)
    {
        $uuid = $command->getUuid();
        $code = $command->getCode();
        $name = $command->getName();

        $this->creator->create($uuid,$code, $name);
    }
}