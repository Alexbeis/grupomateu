<?php


namespace Mateu\Backend\Group\Application\Create;


use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Group\Domain\Entity\Group;
use Mateu\Backend\Group\Infraestructure\GroupRepository;

class GroupCreator
{
    private $groupRepository;
    private $em;

    public function __construct(GroupRepository $groupRepository, EntityManagerInterface $em)
    {
        $this->groupRepository = $groupRepository;
        $this->em = $em;
    }

    public function create($code, $name)
    {
        $group = Group::create($code, $name);
        // TODO: Find if code already exist
        $this->groupRepository->save($group);
        $this->em->flush();
    }
}
