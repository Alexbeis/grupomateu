<?php

namespace Mateu\Backend\IncomingRegister\Application\Get;

use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetIncomingRegisterQueryHandler implements MessageHandlerInterface
{
    /**
     * @var IncomingRegisterRepositoryInterface
     */
    private $incomingRegisterRepository;

    public function __construct(IncomingRegisterRepositoryInterface $incomingRegisterRepository)
    {
        $this->incomingRegisterRepository = $incomingRegisterRepository;
    }

    public function __invoke(GetIncomingRegisterQuery $query)
    {
        return $this->incomingRegisterRepository->findOneByUuid($query->getUuid());
    }

}