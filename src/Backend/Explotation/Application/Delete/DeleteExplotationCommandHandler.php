<?php

namespace Mateu\Backend\Explotation\Application\Delete;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteExplotationCommandHandler implements MessageHandlerInterface
{
    /**
     * @var ExplotationDeletor
     */
    private $explotationDeletor;

    public function __construct(ExplotationDeletor $explotationDeletor)
    {
        $this->explotationDeletor = $explotationDeletor;
    }

    public function __invoke(DeleteExplotationCommand $command)
    {
        $this->explotationDeletor->delete($command->getId());

    }
}