<?php

namespace Mateu\Backend\Animal\Application\Move;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Application\Find\AnimalFinder;
use Mateu\Backend\Animal\Domain\AnimalNotFound;
use Mateu\Backend\Explotation\Application\Find\ExplotationFinder;
use Mateu\Backend\Explotation\Domain\ExplotationNotFound;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AnimalMover
{
    /**
     * @var ExplotationFinder
     */
    private $explotationFinder;

    /**
     * @var AnimalFinder
     */
    private $animalFinder;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    public function __construct(
        ExplotationFinder $explotationFinder,
        AnimalFinder $animalFinder,
        ExplotationRepositoryInterface $explotationRepository,
        EntityManagerInterface $manager,
        MessageBusInterface $eventBus
    ) {
        $this->explotationFinder = $explotationFinder;
        $this->animalFinder = $animalFinder;
        $this->manager = $manager;
        $this->explotationRepository = $explotationRepository;
        $this->eventBus = $eventBus;
    }

    public function move($to, $animals)
    {
        if (!$explotation = $this->explotationFinder->__invoke($to)) {
            throw new ExplotationNotFound();
        }

        foreach ($animals as $animalId) {
            if (!$animal = $this->animalFinder->find($animalId)) {
                throw new AnimalNotFound();
                break;
            }
            $from = $animal->getExplotation()->getName();
            $animal->setExplotation($explotation);
            $this->manager->flush();

            $this->eventBus->dispatch(
                new AnimalMoved($from, $explotation->getName(), $animalId)
            );
        }
    }
}