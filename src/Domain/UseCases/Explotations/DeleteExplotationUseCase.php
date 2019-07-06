<?php

namespace App\Domain\UseCases\Explotations;

use App\Domain\Entity\Explotation;
use App\Domain\Exception\Explotation\NotEmptyExplotationException;
use App\Domain\ExplotationRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeleteExplotationUseCase
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ExplotationRepositoryInterface $explotationRepository, EntityManagerInterface $entityManager)
    {
        $this->explotationRepository = $explotationRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * An explotation can be removed if has no animals inside, else will return an Exception
     */
    public function execute($explotation)
    {
        if (($explotation instanceof Explotation) && $explotation->getAnimal()->count() !== 0) {
            throw new NotEmptyExplotationException('Explotation must be empty of Animals');
        }

        $this->explotationRepository->remove($explotation);

        $this->entityManager->flush();
    }
}