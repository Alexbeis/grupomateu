<?php

namespace Mateu\Backend\Explotation\Application\Save;

use Assert\Assert;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SaveExplotationCommandHandler implements MessageHandlerInterface
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
        $id = (int)$command->getId();
        $code = $command->getCode();
        $name = $command->getName();
        $localization = $command->getLocalization();
        $group = (int)$command->getGroup();

        Assert::lazy()
            ->that($id, 'id')->integer()
            ->that($code, 'Code')->string()->betweenLength(2, 50)
            ->that($name, 'Nombre')->string()->betweenLength(2, 50)
            ->that($localization, 'Localización')->string()->betweenLength(0,50)
            ->that($group)->integer()
            ->verifyNow();

        $this->explotationSaver->save($id, $code, $name, $localization, $group);
    }
}
