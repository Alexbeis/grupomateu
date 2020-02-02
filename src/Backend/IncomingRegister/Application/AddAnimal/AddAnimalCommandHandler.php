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
    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    public function __construct(AnimalAdder $animalAdder, MessageBusInterface $eventBus) {
        $this->animalAdder = $animalAdder;
        $this->eventBus = $eventBus;
    }

    public function __invoke(AddAnimalCommand $addAnimalCommand)
    {
        $this->animalAdder
            ->add(
                $addAnimalCommand->getIncRegisterId(),
                new CodeFromScanner($addAnimalCommand->getData())
            );

        $this->eventBus->dispatch(
            new IncomingRegisterAnimalAdded($addAnimalCommand->getIncRegisterId())
        );
    }
}