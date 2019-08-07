<?php

namespace Mateu\Backend\Explotation\Application\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\ExplotationNotFound;
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
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ExplotationRepositoryInterface $explotationRepository,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    )
    {
        $this->explotationRepository = $explotationRepository;
        $this->entityManager = $entityManager;
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
            throw new ExplotationNotFound('Explotation Not Found', 400);
        }

        if ($explotation->getAnimal()->count() > 0) {
            throw new NotEmptyExplotationException('Explotation must be empty of Animals');
        }

        $this->explotationRepository->remove($explotation);

        $this->entityManager->flush();
        
    }

    /**
     * Events related
     * @return array
     */
    private function registeredEvents()
    {
        return [
           'explotation_deleted' => ExplotationDeleted::class
        ];
    }
}