<?php

namespace Mateu\Backend\InType\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\InType\Domain\Entity\InType;
use Mateu\Backend\InType\Infraestructure\InTypeRepository;

class InTypeCreator
{
    /**
     * @var InTypeRepository
     */
    private $inTypeRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(InTypeRepository $inTypeRepository, EntityManagerInterface $em)
    {
        $this->inTypeRepository = $inTypeRepository;
        $this->em = $em;
    }

    public function create($uuid, $code, $name)
    {
        // TODO: Ensure that code is not already used
        $this->inTypeRepository->save(
            InType::create($uuid, $code, $name)
        );

        $this->em->flush();

        // TODO: Fire related Events
    }
}