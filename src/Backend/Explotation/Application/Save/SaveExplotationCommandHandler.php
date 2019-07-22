<?php

namespace Mateu\Backend\Explotation\Application\Save;

use Mateu\Backend\Explotation\Domain\ExplotationCode;

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
        $id = $command->getId();
        $code = new ExplotationCode($command->getCode());
        $name = $command->getName();
        $localization = $command->getLocalization();

        $this->explotationSaver->save($id, $code->getCode(), $name, $localization);
    }


}