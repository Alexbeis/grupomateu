<?php

namespace Mateu\Backend\Explotation\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\ExplotationCode;
use Mateu\Backend\Explotation\Domain\ExplotationFinderByCode;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Mateu\Backend\Group\Infraestructure\GroupRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class ExplotationCreator implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $explotationRepository;
    private $entityManager;
    private $explotationFinder;
    private $groupRepository;

    public function __construct(
        ExplotationRepositoryInterface $explotationRepository,
        EntityManagerInterface $entityManager,
        ExplotationFinderByCode $explotationFinder,
        GroupRepository $groupRepository
        )
    {
        $this->explotationRepository = $explotationRepository;
        $this->entityManager = $entityManager;
        $this->explotationFinder = $explotationFinder;
        $this->groupRepository = $groupRepository;
    }

    public function create($code, $name, $groupId, $localisation, $createdby)
    {
        $code = new ExplotationCode($code);
        if ($this->explotationFinder->__invoke($code->getCode())) {
            if ($this->logger) {
                $this->logger->alert(sprintf('Explotation code (%s) already used', $code->getCode()));
            }

            throw new ExplotationCodeAlreadyUsed(sprintf('Este código ya existe: %s', $code->getCode()));
        }

        $group = $this->groupRepository->find($groupId);

        $explotation = new Explotation();
        $explotation
            ->setCode($code->getCode())
            ->setName($name)
            ->setGroup($group)
            ->setLocalization($localisation)
            ->setCreatedBy($createdby);

        $this->explotationRepository->save($explotation);

        $this->entityManager->flush();

        if ($this->logger) {
            $this->logger->info(sprintf('Explotation created: %s', $explotation->getCode()));
        }
    }
}
