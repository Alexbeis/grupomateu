<?php

namespace Mateu\Backend\Explotation\Application\Delete;

use Mateu\Backend\Explotation\Domain\ExplotationNotFound;

class DeleteExplotationCommandHandler
{
    /**
     * @var ExplotationDeletor
     */
    private $explotationDeletor;

    public function __construct(ExplotationDeletor $explotationDeletor)
    {
        $this->explotationDeletor = $explotationDeletor;
    }

    public function handle(DeleteExplotationCommand $command)
    {
        $this->explotationDeletor->delete($command->getId());

    }

}