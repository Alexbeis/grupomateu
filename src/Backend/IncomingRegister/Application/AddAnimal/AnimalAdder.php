<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\Animal\Domain\CrotalMotherNum;
use Mateu\Backend\Animal\Domain\CrotalNum;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\IncomingRegister\Domain\CodeFromScanner;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Mateu\Backend\IncomingRegister\Domain\InfoExtractor;
use Mateu\Backend\Race\Domain\RaceRepositoryInterface;
use Mateu\Shared\Application\Validation\ExecutionContext;
use Mateu\Shared\Application\Validation\Violation;
use Mateu\Shared\Application\Validation\ViolationsFormatter;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\Registry;

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

    /**
     * @var Registry
     */
    private $workflow;

    public function __construct(
        RaceRepositoryInterface $raceRepository,
        IncomingRegisterRepositoryInterface $incomingRegisterRepository,
        AnimalRepositoryInterface $animalRepository,
        EntityManagerInterface $entityManager,
        MessageBusInterface $eventBus,
        Registry $workflow
    ) {
        $this->raceRepository = $raceRepository;
        $this->incomingRegisterRepository = $incomingRegisterRepository;
        $this->entityManager = $entityManager;
        $this->animalRepository = $animalRepository;
        $this->eventBus = $eventBus;
        $this->workflow = $workflow;
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

        $context = new ExecutionContext();

        /**
         * Check for a valid Incoming register
         * @var IncomingRegister $incomingRegister
         */
        if (!$incomingRegister = $this->incomingRegisterRepository->findOneById($incRegisterId)) {
            $context->addViolation(
                new Violation('Registro de entrada no encontrado', [])
            );
        }

        /**
         * Check for a valid Animal Race
         */
        if (!$race = $this->raceRepository->findOneByCode($raceCode)) {
            $context->addViolation(
                new Violation('Código Raza: %s no encontrada', $raceCode)
            );
        }

        $crotalNum = new CrotalNum($crotalRaw);
        $crotalNumMother = new CrotalMotherNum($crotalRawMother);

        /**
         * Check if animal is already on that register
         */
        $result = $incomingRegister->getAnimals()->filter(function ($element) use ($crotalNum){
            return $element->getCrotal() === $crotalNum->value();
        });

        if (!$result->isEmpty()) {
            $context->addViolation(
                new Violation('Crotal: %s ya esta en este registro', [$crotalNum->value()])
            );
        }

        /**
         * Animal can be on the system or can be first time on the system.
         */
        if (!$animal = $this->animalRepository->findOneByCrotal($crotalNum->value())) {
            $animal = Animal::fromAutoAdding(
                $crotalNum,
                $crotalNumMother,
                $birthDate,
                $incomingRegister->getExplotation(),
                $race,
                $sex == 2 ? 'female':'male'
            );
        }

        $animalStateMachine = $this->workflow->get($animal);

        if ($animal->getId()) {
            $canIncome = $animalStateMachine->can($animal,'to_income');
        } else {
            $canIncome = true;
        }

        if(!$canIncome) {
            $context->addViolation(
                new Violation(
                    'El crotal: %s, debe salir para poder volver a entrar.',
                    $crotalNum->value()
                )
            );
        }

        if (!$context->getViolations()->violations()->isEmpty()) {
            throw new Exception(
                (new ViolationsFormatter(
                    $context->getViolations())
                )->toString());
        }

        $this->entityManager->getConnection()->beginTransaction();

        try {

            if ($animal->getId()){
                $animalStateMachine->apply($animal, 'to_income');
            }

            $incomingRegister->addAnimal($animal);

            $this->entityManager->flush();

            $this->eventBus->dispatch(
                new IncomingRegisterAnimalAdded(
                    $incRegisterId,
                    $incomingRegister->getUuid(),
                    $animal->getId(),
                    $animal->getCrotal()
                )
            );

            $this->entityManager->getConnection()->commit();

        } catch (Exception $e) {
            $this->entityManager->getConnection()->rollBack();

            throw $e;
        }
    }
}
