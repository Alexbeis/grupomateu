<?php

namespace Mateu\Backend\Explotation\Application\PostOwner;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\Entity\Owner;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Mateu\Backend\Explotation\Infraestructure\OwnerRepository;

class OwnerCreator
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var OwnerRepository
     */
    private $ownerRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        ExplotationRepositoryInterface $explotationRepository,
        OwnerRepository $ownerRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->explotationRepository = $explotationRepository;
        $this->ownerRepository = $ownerRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke($ownerData)
    {
        if ($explotation = $this->explotationRepository->findOneById($ownerData['exp_id'])) {
            /**
             * @var Owner $owner
             */
            if ($owner = $explotation->getOwner()) {
                //Update it
                $owner
                    ->setName($ownerData['owner_name'])
                    ->setCode($ownerData['owner_code'])
                    ->setNif($ownerData['owner_nif']);

            } else {
                $owner = Owner::create(
                    $ownerData['owner_code'],
                    $ownerData['owner_name'],
                    $ownerData['owner_nif']
                );
            }

            /**
             * @var Explotation $explotation
             */
            $explotation->setOwner($owner);
            $this->entityManager->persist($explotation);
            $this->entityManager->flush();
        }
    }
}