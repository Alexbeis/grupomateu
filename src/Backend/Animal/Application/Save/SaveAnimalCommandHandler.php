<?php

namespace Mateu\Backend\Animal\Application\Save;

use Mateu\Backend\Animal\Domain\CrotalMotherNum;
use Mateu\Backend\Animal\Domain\CrotalNum;
use Mateu\Backend\Animal\Domain\Genre;
use Mateu\Backend\Animal\Domain\RaceId;
use Mateu\Backend\Animal\Domain\WeightIn;
use Mateu\Backend\Animal\Domain\WeightOut;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SaveAnimalCommandHandler implements MessageHandlerInterface
{
    /**
     * @var AnimalSaver
     */
    private $animalSaver;

    public function __construct(AnimalSaver $animalSaver)
    {

        $this->animalSaver = $animalSaver;
    }

    public function __invoke(SaveAnimalCommand $command)
    {
        $crotal = new CrotalNum($command->getCrotal());
        $crotalMother = new CrotalMotherNum($command->getCrotalMother());
        $internalNum = substr($crotal->value(), -4);
        $weightIn = new WeightIn($command->getWeightIn());
        $weightOut = new WeightOut($command->getWeightOut());
        $birthdate = $command->getBirthdate();
        $genre = new Genre($command->getGenre());
        $raceId = new RaceId($command->getRaceId());

        $this->animalSaver->save(
            $command->getId(),
            $crotal->value(),
            $crotalMother->value(),
            $internalNum,
            $weightIn->value(),
            $weightOut->value(),
            $birthdate,
            $genre->value(),
            $raceId->value()
        );
    }
}