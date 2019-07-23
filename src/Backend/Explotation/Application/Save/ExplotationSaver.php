<?php

namespace Mateu\Backend\Explotation\Application\Save;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Application\Create\ExplotationCodeAlreadyUsed;
use Mateu\Backend\Explotation\Domain\ExplotationFinderByCode;
use Mateu\Backend\Explotation\Domain\ExplotationFinderById;
use Mateu\Backend\Explotation\Domain\ExplotationNotFound;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;

class ExplotationSaver
{
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ExplotationFinderByCode
     */
    private $explotationFinderByCode;

    /**
     * @var ExplotationFinderById
     */
    private $explotationFinderById;

    public function __construct(
        ExplotationRepositoryInterface $explotationRepository,
        ExplotationFinderByCode $explotationFinderByCode,
        ExplotationFinderById $explotationFinderById,
        EntityManagerInterface $em
        )
    {
        $this->explotationRepository = $explotationRepository;
        $this->explotationFinderByCode = $explotationFinderByCode;
        $this->explotationFinderById = $explotationFinderById;
        $this->em = $em;
    }

    public function save($id, $code, $name, $localization)
    {
        $explotation = $this->explotationFinderById->__invoke($id);

        if(!$explotation) {
            throw new ExplotationNotFound('Explotación no encontrada');
        }

        $codeAlreadyUsed = $this->explotationFinderByCode->__invoke($code);

        if ($codeAlreadyUsed && $codeAlreadyUsed->getId() != $id) {
            throw new ExplotationCodeAlreadyUsed('Código existente!');
        }

        $explotation
            ->setCode($code)
            ->setName($name)
            ->setLocalization($localization);

        $this->explotationRepository->save($explotation);
        $this->em->flush();
    }
}