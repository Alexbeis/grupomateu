<?php

namespace Mateu\Backend\Explotation\Application\Delete;

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
        try {
            $this->explotationDeletor->delete($command->getId());

        } catch (NotEmptyExplotationException $e) {

        }

    }

}