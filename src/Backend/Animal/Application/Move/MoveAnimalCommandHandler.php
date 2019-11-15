<?php

namespace Mateu\Backend\Animal\Application\Move;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MoveAnimalCommandHandler implements MessageHandlerInterface
{
    /**
     * @var AnimalMover
     */
    private $animalMover;

    public function __construct(AnimalMover $animalMover)
    {
        $this->animalMover = $animalMover;
    }

    public function __invoke(MoveAnimalCommand $command)
    {
        $this->animalMover->move($command->getExplotationTo(), $command->getAnimals());
    }

}