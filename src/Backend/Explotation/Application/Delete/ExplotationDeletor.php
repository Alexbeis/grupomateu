<?php

namespace Mateu\Backend\Explotation\Application\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Psr\Log\LoggerInterface;
use SimpleBus\SymfonyBridge\Bus\EventBus;

class ExplotationDeletor
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var EventBus
     */
    private $eventBus;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ExplotationRepositoryInterface $explotationRepository,
        EntityManagerInterface $entityManager,
        EventBus $eventBus,
        LoggerInterface $logger
    )
    {
        $this->explotationRepository = $explotationRepository;
        $this->entityManager = $entityManager;
        $this->eventBus = $eventBus;
        $this->logger = $logger;
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function delete($id)
    {
        $explotation = $this->explotationRepository->find($id);

        if (!$explotation) {
            throw new \Exception('Explotation Not Found');
        }

        if (($explotation instanceof Explotation) && $explotation->getAnimal()->count() > 0) {
            throw new \Exception('Explotation must be empty of Animals');
        }

        $this->explotationRepository->remove($explotation);

        $this->entityManager->flush();

        $this->eventBus->handle(
            new ExplotationDeleted($explotation->getCode(), $explotation->getCreatedBy())
        );
    }

}