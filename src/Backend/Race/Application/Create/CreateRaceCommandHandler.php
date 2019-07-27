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
        $code = $command->getCode();
        $name = $command->getName();

        $this->creator->create($code, $name);
    }

}