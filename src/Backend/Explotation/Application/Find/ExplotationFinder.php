<?php

namespace Mateu\Backend\Explotation\Application\Find;

use Mateu\Backend\Explotation\Domain\ExplotationFinderById as DomainExplotationFinder;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;

class ExplotationFinder
{
    /**
     * @var DomainExplotationFinder
     */
    private $finder;

    public function __construct(ExplotationRepositoryInterface $repository)
    {
        $this->finder = new DomainExplotationFinder($repository);
    }

    public function __invoke($id)
    {
        return $this->finder->__invoke($id);
    }

}