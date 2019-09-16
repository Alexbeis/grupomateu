<?php

namespace Mateu\Backend\Animal\Application\GetAnimal;

use Mateu\Backend\Animal\Application\Find\AnimalFinder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAnimalQueryHandler implements MessageHandlerInterface
{
    /**
     * @var AnimalFinder
     */
    private $animalFinder;

    public function __construct(AnimalFinder $animalFinder)
    {
        $this->animalFinder = $animalFinder;
    }

    public function __invoke(GetAnimalQuery $animalQuery)
    {
        return $this->animalFinder->find($animalQuery->getAnimalId());
    }

}