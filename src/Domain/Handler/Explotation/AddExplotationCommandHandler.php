<?php

namespace App\Domain\Handler\Explotation;

use App\Domain\Command\Explotation\AddExplotationCommand;
use App\Domain\Entity\Explotation;
use App\Domain\ExplotationRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class AddExplotationCommandHandler
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

    public function handle(AddExplotationCommand $command)
    {
        $explotation = new Explotation();
        $explotation
            ->setCode($command->getCode())
            ->setName($command->getName())
            ->setLocalization($command->getLocalization())
            ->setCreatedBy($command->getCreatedBy());

        $this->explotationRepository->save($explotation);

        $this->entityManager->flush();

    }

}