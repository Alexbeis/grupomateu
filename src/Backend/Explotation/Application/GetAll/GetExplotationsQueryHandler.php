<?php

namespace Mateu\Backend\Explotation\Application\GetAll;

use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetExplotationsQueryHandler
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;

    public function __construct(ExplotationRepositoryInterface $explotationRepository)
    {
        $this->explotationRepository = $explotationRepository;
    }

    public function __invoke(GetExplotationsQuery $explotationsQuery)
    {
        return $this->explotationRepository->findAll();
    }
}