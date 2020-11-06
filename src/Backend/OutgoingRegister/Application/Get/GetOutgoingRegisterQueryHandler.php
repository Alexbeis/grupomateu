<?php

namespace Mateu\Backend\OutgoingRegister\Application\Get;

use Mateu\Backend\OutgoingRegister\Infraestructure\OutgoingRegisterRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetOutgoingRegisterQueryHandler implements MessageHandlerInterface
{
    /**
     * @var OutgoingRegisterRepository
     */
    private $outgoingRegisterRepository;

    public function __construct(OutgoingRegisterRepository $outgoingRegisterRepository)
    {
        $this->outgoingRegisterRepository = $outgoingRegisterRepository;
    }

    public function __invoke(GetOutgoingRegisterQuery $outgoingRegisterQuery)
    {
        return $this->outgoingRegisterRepository
            ->findOneBy(
                [
                    'uuid' => $outgoingRegisterQuery->getUuid()
                ]
            );
    }

}