<?php

namespace Mateu\Backend\Explotation\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;

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