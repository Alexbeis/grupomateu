<?php

namespace Mateu\Backend\Explotation\Application\Save;

use Mateu\Backend\Explotation\Domain\ExplotationFinder;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;

class ExplotationSaver
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var ExplotationFinder
     */
    private $explotationFinder;

    public function __construct(ExplotationRepositoryInterface $explotationRepository, ExplotationFinder $explotationFinder)
    {
        $this->explotationRepository = $explotationRepository;
        $this->explotationFinder = $explotationFinder;
    }

    public function save($id, $name, $code, $localization)
    {
        $explotation = $this->explotationFinder->__invoke($id);

        dd($explotation);


    }

}