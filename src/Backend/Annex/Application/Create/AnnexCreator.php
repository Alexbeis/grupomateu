<?php

namespace Mateu\Backend\Annex\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Application\Find\AnimalFinder;
use Mateu\Backend\Animal\Domain\AnimalNotFound;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Annex\Domain\AnimalAlreadyAnnexed;
use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Mateu\Backend\Annex\Domain\Entity\Annex;

final class AnnexCreator
{
    private $annexRepository;
    /**
     * @var AnimalFinder
     */
    private $animalFinder;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        AnnexRepositoryInterface $annexRepository,
        AnimalFinder $animalFinder,
        EntityManagerInterface $em
    )
    {
        $this->annexRepository = $annexRepository;
        $this->animalFinder = $animalFinder;
        $this->em = $em;
    }

    public function create($id)
    {
        /** @var Animal $animal */

        if (!$animal = $this->animalFinder->find($id)) {
            throw new AnimalNotFound();
        }

        if (!is_null($animal->getAnnex())) {
            throw new AnimalAlreadyAnnexed('Ya esta Anexado.');
        }

        $annex = Annex::fromAnimal($animal);
        $this->annexRepository->save($annex);
        $this->em->flush();
    }

}