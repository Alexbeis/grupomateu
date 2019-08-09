<?php

namespace Mateu\Backend\Explotation\Application\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\ExplotationNotFound;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use SimpleBus\SymfonyBridge\Bus\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class ExplotationDeletor implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MessageBusInterface
     */
    private $eventBus;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(
        ExplotationRepositoryInterface $explotationRepository,
        EntityManagerInterface $entityManager,
        MessageBusInterface $eventBus,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->explotationRepository = $explotationRepository;
        $this->entityManager = $entityManager;
        $this->eventBus = $eventBus;
        $this->tokenStorage = $tokenStorage;
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
            $this->logger->debug(sprintf('Explotation with id: %d not found', $id));
            throw new ExplotationNotFound('Explotación no encontrada', 400);
        }

        if ($explotation->getAnimal()->count() > 0) {
            $this->logger->debug(sprintf('Explotation (%s) must be empty of animals.', $explotation->getCode()));
            throw new NotEmptyExplotationException('La explotación debe estar vacia de animales.');
        }

        $this->explotationRepository->remove($explotation);

        $this->entityManager->flush();

        $this->eventBus->dispatch(
            new ExplotationDeleted(
                $explotation->getCode(),
                $this->tokenStorage->getToken()->getUser()
            )
        );
    }
}
