<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\Animal\Domain\CrotalAlreadyExist;
use Mateu\Backend\Animal\Domain\CrotalMotherNum;
use Mateu\Backend\Animal\Domain\CrotalNum;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\IncomingRegister\Domain\CodeFromScanner;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterNotFound;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Mateu\Backend\IncomingRegister\Domain\InfoExtractor;
use Mateu\Backend\Race\Domain\RaceNotFound;
use Mateu\Backend\Race\Domain\RaceRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AnimalAdder
{
    /**
     * @var RaceRepositoryInterface
     */
    private $raceRepository;
    /**
     * @var IncomingRegisterRepositoryInterface
     */
    private $incomingRegisterRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var AnimalRepositoryInterface
     */
    private $animalRepository;
    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    public function __construct(
        RaceRepositoryInterface $raceRepository,
        IncomingRegisterRepositoryInterface $incomingRegisterRepository,
        AnimalRepositoryInterface $animalRepository,
        EntityManagerInterface $entityManager,
        MessageBusInterface $eventBus
    ) {
        $this->raceRepository = $raceRepository;
        $this->incomingRegisterRepository = $incomingRegisterRepository;
        $this->entityManager = $entityManager;
        $this->animalRepository = $animalRepository;
        $this->eventBus = $eventBus;
    }

    public function add(int $incRegisterId, CodeFromScanner $data)
    {
        list(
            $birthDate,
            $sex,
            $raceCode,
            $crotalRaw,
            $crotalRawMother
            ) = (new InfoExtractor($data))->extract();

        /**
         * @var IncomingRegister $incomingRegister
         */
        if (!$incomingRegister = $this->incomingRegisterRepository->findOneById($incRegisterId)) {
            throw new IncomingRegisterNotFound('Registro de entrada no encontrado');
        }

        if (!$race = $this->raceRepository->findOneByCode($raceCode)) {
            throw new RaceNotFound('Raza no econtrada');
        }

        $crotalNum = new CrotalNum($crotalRaw);
        $crotalNumMother = new CrotalMotherNum($crotalRawMother);

        if ($this->animalRepository->existsByCrotalNum($crotalNum)) {
            throw new CrotalAlreadyExist(sprintf('Crotal: %s existente', $crotalNum->value()));
        }

        $animal = Animal::fromAutoAdding(
            $crotalNum,
            $crotalNumMother,
            $birthDate,
            $incomingRegister->getExplotation(),
            $race,
            $sex == 2 ? 'female':'male'
        );

        $incomingRegister->addAnimal($animal);

        $this->entityManager->flush();

        /**
         * Emit Event
         */
        $this->eventBus->dispatch(
            new IncomingRegisterAnimalAdded($incRegisterId, $animal->getId())
        );
    }
}