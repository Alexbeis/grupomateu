<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Domain\CrotalMotherNum;
use Mateu\Backend\Animal\Domain\CrotalNum;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterNotFound;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Mateu\Backend\Race\Domain\RaceNotFound;
use Mateu\Backend\Race\Domain\RaceRepositoryInterface;
use Mateu\Shared\Domain\ValueObject\StringValueObject;

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

    public function __construct(
        RaceRepositoryInterface $raceRepository,
        IncomingRegisterRepositoryInterface $incomingRegisterRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->raceRepository = $raceRepository;
        $this->incomingRegisterRepository = $incomingRegisterRepository;
        $this->entityManager = $entityManager;
    }

    public function add(int $incRegisterId, StringValueObject $data)
    {
        list($crotal, $mixed, $crotalMother) = explode('/', $data->value());

        preg_match('/(\d{8,8})(\d{1,1})(\d{4,4})/', $mixed, $output);

        if (!$output) {

        }

        $stringDate = $output[1];
        $sex = $output[2];
        $raceCode = $output[3];

        $day = substr($stringDate,0, 2);
        $month = substr($stringDate,2, 2);
        $year = substr($stringDate,4, 4);

        $birthDate = (new \DateTime())
            ->setDate($year, $month, $day);

        /**
         * @var IncomingRegister $incomingRegister
         */
        if (!$incomingRegister = $this->incomingRegisterRepository->findOneById($incRegisterId)) {
            throw new IncomingRegisterNotFound('Registro de entrada no encontrado');
        }

        if (!$race = $this->raceRepository->findOneByCode($raceCode)) {
            throw new RaceNotFound('Raza no econtrada');
        }

        $crotalNum = new CrotalNum($crotal);
        $crotalNumMother = new CrotalMotherNum($crotalMother);

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
    }
}