<?php

namespace Mateu\Backend\Explotation\Application\GetAll;

use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;

class GetAllExplotationsUseCase
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;

    public function __construct(ExplotationRepositoryInterface $explotationRepository)
    {
        $this->explotationRepository = $explotationRepository;
    }

    public function execute()
    {
        $explotations = $this->explotationRepository->findAll();

        return $explotations;

    }

}