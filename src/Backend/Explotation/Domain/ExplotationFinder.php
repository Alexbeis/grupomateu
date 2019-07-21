<?php

namespace Mateu\Backend\Explotation\Domain;

use Mateu\Backend\Explotation\Domain\Entity\Explotation;

class ExplotationFinder
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;

    public function __construct(ExplotationRepositoryInterface $explotationRepository)
    {
        $this->explotationRepository = $explotationRepository;
    }

    public function __invoke($id): Explotation
    {
        $explotation = $this->explotationRepository->find($id);

        if (null == $explotation) {
            throw new ExplotationNotFound('Explotación no encontrada');
        }

        return $explotation;
    }

}