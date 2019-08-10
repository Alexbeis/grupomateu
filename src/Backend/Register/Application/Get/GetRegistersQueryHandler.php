<?php

namespace Mateu\Backend\Register\Application\Get;

use Mateu\Backend\Register\Domain\RegisterRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetRegistersQueryHandler implements MessageHandlerInterface
{
    private $registerRepository;

    public function __construct(RegisterRepositoryInterface $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function __invoke(GetRegistersQuery $registersQuery)
    {
        return $this->registerRepository->findAll();
    }
}