<?php

namespace App\Domain\UseCases\Explotations;

use App\Domain\ExplotationRepositoryInterface;

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