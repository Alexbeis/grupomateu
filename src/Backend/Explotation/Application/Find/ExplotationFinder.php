<?php

namespace Mateu\Backend\Explotation\Application\Find;

use Mateu\Backend\Explotation\Domain\ExplotationFinder as DomainExplotationFinder;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;

class ExplotationFinder
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;

    public function __construct(ExplotationRepositoryInterface $repository)
    {
        $this->explotationRepository = new DomainExplotationFinder($repository);
    }

    public function __invoke($id)
    {
        return $this->explotationRepository->__invoke($id);
    }

}