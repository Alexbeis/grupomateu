<?php

namespace Mateu\Backend\Explotation\Application\Save;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\ExplotationFinder;
use Mateu\Backend\Explotation\Domain\ExplotationNotFound;
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
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ExplotationRepositoryInterface $explotationRepository,
        ExplotationFinder $explotationFinder,
        EntityManagerInterface $em
        )
    {
        $this->explotationRepository = $explotationRepository;
        $this->explotationFinder = $explotationFinder;
        $this->em = $em;
    }

    public function save($id, $code, $name, $localization)
    {
        $explotation = $this->explotationFinder->__invoke($id);

        if(!$explotation) {
            throw new ExplotationNotFound('Explotación no encontrada');
        }
        $explotation
            ->setCode($code)
            ->setName($name)
            ->setLocalization($localization);

        $this->explotationRepository->save($explotation);
        $this->em->flush();
    }
}