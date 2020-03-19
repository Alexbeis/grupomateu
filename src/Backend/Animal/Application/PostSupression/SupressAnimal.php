<?php

namespace Mateu\Backend\Animal\Application\PostSupression;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Domain\AnimalNotFound;
use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\Animal\Domain\Entity\Supression;
use Symfony\Component\Messenger\MessageBusInterface;

class SupressAnimal
{
    /**
     * @var AnimalRepositoryInterface
     */
    private $animalRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    public function __construct(
        AnimalRepositoryInterface $animalRepository,
        EntityManagerInterface $entityManager,
        MessageBusInterface $eventBus
    ) {
        $this->animalRepository = $animalRepository;
        $this->entityManager = $entityManager;
        $this->eventBus = $eventBus;
    }

    public function supress($animalId, $days, $product, DateTime $supressionDate)
    {
        if (!$animal = $this->animalRepository->find($animalId)) {
            throw new AnimalNotFound();
        }

        $supression = new Supression($supressionDate, $product, (int)$days);

        $animal->setSupression($supression);

        $this->entityManager->persist($supression);
        $this->entityManager->flush();

        /**
         * Events
         */
        $this->eventBus->dispatch(
            new AnimalSupressed(
                $animalId,
                sprintf(
                    'Inicio Supresión: %s, Producto: %s, dias: %d',
                    $supressionDate->format('d-m-Y'),
                    $product,
                    $days
                )
            )
        );
    }
}