<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal\Event;

use Mateu\Backend\IncomingRegister\Application\AddAnimal\IncomingRegisterAnimalAdded;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddInitialMovementWhenAnimalAddedEventHandler implements MessageHandlerInterface
{

    public function __construct()
    {
    }

    public function __invoke(IncomingRegisterAnimalAdded $animalAdded)
    {
        // TODO: Think if necessary first movement

    }

}