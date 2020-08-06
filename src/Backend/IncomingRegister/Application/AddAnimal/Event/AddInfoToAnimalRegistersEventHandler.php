<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal\Event;

use Mateu\Backend\AnimalRegisters\Application\Create\AnimalRegisterCreator;
use Mateu\Backend\IncomingRegister\Application\AddAnimal\IncomingRegisterAnimalAdded;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddInfoToAnimalRegistersEventHandler implements MessageHandlerInterface
{
    /**
     * @var AnimalRegisterCreator
     */
    private $creator;

    public function __construct(AnimalRegisterCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(IncomingRegisterAnimalAdded $animalAdded)
    {
        $this->creator->create($animalAdded->getCrotal(), $animalAdded->getIncomingRegisterUuid());
    }
}