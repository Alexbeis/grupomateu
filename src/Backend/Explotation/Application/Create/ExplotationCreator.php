<?php

namespace Mateu\Backend\Explotation\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;

class ExplotationCreator
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

    public function create($code, $name, $localisation, $createdby)
    {
        $explotation = new Explotation();
        $explotation
            ->setCode($code)
            ->setName($name)
            ->setLocalization($localisation)
            ->setCreatedBy($createdby);

        $this->explotationRepository->save($explotation);

        $this->entityManager->flush();

    }



}