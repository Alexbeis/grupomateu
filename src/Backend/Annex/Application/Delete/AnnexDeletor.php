<?php

namespace Mateu\Backend\Annex\Application\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Application\Find\AnimalFinder;
use Mateu\Backend\Animal\Domain\AnimalNotFound;
use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;

final class AnnexDeletor
{
    /**
     * @var AnimalFinder
     */
    private $animalFinder;
    /**
     * @var AnnexRepositoryInterface
     */
    private $annexRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        AnimalFinder $animalFinder,
        AnnexRepositoryInterface $annexRepository,
        EntityManagerInterface $em)
    {
        $this->animalFinder = $animalFinder;
        $this->annexRepository = $annexRepository;
        $this->em = $em;
    }

    public function delete($id)
    {
        if (!$animal = $this->animalFinder->find($id) ) {
            throw new AnimalNotFound('Este animal no esta en la granja');
        }

        $this->annexRepository->remove($animal->getAnnex());
        $this->em->flush();
    }

}