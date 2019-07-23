<?php

namespace Mateu\Backend\Explotation\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\ExplotationCode;
use Mateu\Backend\Explotation\Domain\ExplotationFinderByCode;
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
    /**
     * @var ExplotationFinderByCode
     */
    private $explotationFinder;

    public function __construct(
        ExplotationRepositoryInterface $explotationRepository,
        EntityManagerInterface $entityManager,
        ExplotationFinderByCode $explotationFinder
        )
    {
        $this->explotationRepository = $explotationRepository;
        $this->entityManager = $entityManager;
        $this->explotationFinder = $explotationFinder;
    }

    public function create($code, $name, $localisation, $createdby)
    {
        $code = new ExplotationCode($code);
        if ($found = $this->explotationFinder->__invoke($code->getCode())) {
            throw new ExplotationCodeAlreadyUsed();
        }
        $explotation = new Explotation();
        $explotation
            ->setCode($code->getCode())
            ->setName($name)
            ->setLocalization($localisation)
            ->setCreatedBy($createdby);

        $this->explotationRepository->save($explotation);

        $this->entityManager->flush();

    }



}