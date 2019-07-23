<?php

namespace Mateu\Backend\Explotation\Domain;

use Mateu\Backend\Explotation\Domain\Entity\Explotation;

/**
 * Class ExplotationFinderByCode
 * @package Mateu\Backend\Explotation\Domain
 *
 * Used to find Explotation by its code
 */
class ExplotationFinderByCode
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;

    public function __construct(ExplotationRepositoryInterface $explotationRepository)
    {
        $this->explotationRepository = $explotationRepository;
    }

    public function __invoke($code): ?Explotation
    {
        return $this->explotationRepository->findOneBy(['code' => $code]);
    }
}