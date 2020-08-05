<?php

namespace Mateu\Backend\AnimalRegisters\Application\Create;

use Mateu\Backend\IncomingRegister\Application\AddAnimal\IncomingRegisterAnimalAdded;

class CreateAnimalRegistersCommandHandler
{
    /**
     * @var AnimalRegisterCreator
     */
    private $creator;

    public function __construct(AnimalRegisterCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(CreateAnimalRegistersCommand $animalRegistersCommand)
    {

    }

}