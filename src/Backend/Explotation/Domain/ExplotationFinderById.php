<?php

namespace Mateu\Backend\Explotation\Domain;

use Mateu\Backend\Explotation\Domain\Entity\Explotation;

/**
 * Class ExplotationFinderById
 * @package Mateu\Backend\Explotation\Domain
 *
 * Used To find explotations by database ID.
 */
class ExplotationFinderById
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;

    public function __construct(ExplotationRepositoryInterface $explotationRepository)
    {
        $this->explotationRepository = $explotationRepository;
    }

    public function __invoke($id): ?Explotation
    {
        //return  $this->explotationRepository->find($id);
        //dd($this->explotationRepository->getExplotationWithAnimals($id));
        return  $this->explotationRepository->getExplotationWithAnimals($id);
    }
}