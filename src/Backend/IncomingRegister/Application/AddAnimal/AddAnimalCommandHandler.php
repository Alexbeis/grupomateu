<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal;

use Mateu\Backend\IncomingRegister\Domain\CodeFromScanner;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AddAnimalCommandHandler implements MessageHandlerInterface
{
    /**
     * @var AnimalAdder
     */
    private $animalAdder;


    public function __construct(AnimalAdder $animalAdder) {
        $this->animalAdder = $animalAdder;
    }

    public function __invoke(AddAnimalCommand $addAnimalCommand)
    {
        $this->animalAdder
            ->add(
                $addAnimalCommand->getIncRegisterId(),
                new CodeFromScanner($addAnimalCommand->getData())
            );
    }
}