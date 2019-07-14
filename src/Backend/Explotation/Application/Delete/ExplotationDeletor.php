<?php

namespace Mateu\Backend\Explotation\Application\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;

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

    public function __construct(ExplotationRepositoryInterface $explotationRepository, EntityManagerInterface $entityManager)
    {
        $this->explotationRepository = $explotationRepository;
        $this->entityManager = $entityManager;
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
            throw new \Exception('Explotation Not Found');
        }

        if (($explotation instanceof Explotation) && $explotation->getAnimal()->count() > 0) {
            throw new \Exception('Explotation must be empty of Animals');
        }

        $this->explotationRepository->remove($explotation);

        $this->entityManager->flush();

    }

}