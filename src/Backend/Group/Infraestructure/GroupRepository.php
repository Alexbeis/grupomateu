<?php

namespace Mateu\Backend\Group\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\Group\Domain\Entity\Group;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function save(Group $group)
    {
        $this->_em->persist($group);
    }
}