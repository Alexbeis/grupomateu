<?php

namespace Mateu\Backend\AnimalRegisters\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\AnimalRegisters\Domain\AnimalRegistersInterface;
use Mateu\Backend\AnimalRegisters\Domain\Entity\AnimalRegisters;

class DoctrineAnimalRegistersRepository extends ServiceEntityRepository implements AnimalRegistersInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalRegisters::class);
    }

    /**
     *  @inheritDoc
     */
    public function persist(AnimalRegisters $animalRegisters): void
    {
        $this->_em->persist($animalRegisters);
    }

    /**
     * @inheritDoc
     */
    public function canIncome(Animal $animal): bool
    {
        if (!$this->exists($animal)) {
            return true;
        }

        $qb = $this->createQueryBuilder('ar');
        $result = $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('ar.crotal', '?1'),
                    $qb->expr()->isNotNull('ar.incomingRegisterUuid'),
                    $qb->expr()->isNull('ar.outgoingRegisterUuid')
                )
            )
            ->setParameter('1', $animal->getCrotal())
            ->orderBy('ar.id', 'DESC')
            ->setMaxResults(1);

        return empty($result->getQuery()->getResult());
    }

    /**
     * @inheritDoc
     */
    public function canLeave(Animal $animal): bool
    {
        if (!$this->exists($animal)) {
            return false;
        }

        $qb = $this->createQueryBuilder('ar');
        $result = $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq('ar.crotal', '?1'),
                $qb->expr()->isNotNull('ar.incomingRegisterUuid'),
                $qb->expr()->isNotNull('ar.outgoingRegisterUuid')
            )
        )
            ->orderBy('ar.id', 'DESC')
            ->setMaxResults(1)
            ->setParameter('1', $animal->getCrotal());

        return empty($result->getQuery()->getResult());
    }

    public function exists(Animal $animal): bool
    {
        $qb = $this->createQueryBuilder('ar');
        $qb->where(
            $qb->expr()->eq('ar.crotal', '?1')
        )->setParameter('1', $animal->getCrotal());

        $result = $qb->getQuery()->getResult();

        return !empty($result);
    }
}