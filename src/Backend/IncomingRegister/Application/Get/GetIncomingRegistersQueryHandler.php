<?php

namespace Mateu\Backend\IncomingRegister\Application\Get;

use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetIncomingRegistersQueryHandler implements MessageHandlerInterface
{
    private $registerRepository;

    public function __construct(IncomingRegisterRepositoryInterface $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function __invoke(GetIncomingRegistersQuery $registersQuery)
    {
        return $this->registerRepository->findAll();
    }
}