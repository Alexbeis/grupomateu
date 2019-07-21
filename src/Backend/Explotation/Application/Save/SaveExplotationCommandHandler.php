<?php

namespace Mateu\Backend\Explotation\Application\Save;

class SaveExplotationCommandHandler
{
    /**
     * @var ExplotationSaver
     */
    private $explotationSaver;

    public function __construct(ExplotationSaver $explotationSaver)
    {
        $this->explotationSaver = $explotationSaver;
    }

    public function __invoke(SaveExplotationCommand $command)
    {
        dd($command);
    }


}