<?php

namespace Mateu\Backend\Group\Application\GetAll;

use Mateu\Backend\Group\Infraestructure\GroupRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAllGroupsQueryHandler implements MessageHandlerInterface
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function __invoke(GetAllGroupsQuery $allGroupsQuery)
    {
        return $this->groupRepository->findAll();
    }

}