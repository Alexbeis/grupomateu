<?php

namespace Mateu\Backend\History\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Application\Find\AnimalFinder;
use Mateu\Backend\Animal\Domain\AnimalNotFound;
use Mateu\Backend\History\Domain\Entity\History;
use Mateu\Backend\History\Infraestructure\HistoryRepository;
use Symfony\Component\Security\Core\Security;

final class HistoryCreator
{
    /**
     * @var AnimalFinder
     */
    private $animalFinder;
    /**
     * @var HistoryRepository
     */
    private $historyRepository;
    /**
     * @var Security
     */
    private $security;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(
        AnimalFinder $animalFinder,
        HistoryRepository $historyRepository,
        Security $security,
        EntityManagerInterface $em
    )
    {
        $this->animalFinder = $animalFinder;
        $this->historyRepository = $historyRepository;
        $this->security = $security;
        $this->em = $em;
    }

    public function create($animal_id, $comment)
    {
        if (!$animal = $this->animalFinder->find($animal_id)) {
            throw new AnimalNotFound();
        }
        $history = (new History())
            ->setCreatedBy($this->security->getUser())
            ->setAnimal($animal)
            ->setComment($comment);

        $this->historyRepository->save($history);
        $this->em->flush();

    }

}