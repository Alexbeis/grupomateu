<?php

namespace Mateu\Backend\Animal\Application\PostSupression\Event;

use Mateu\Backend\Animal\Application\PostSupression\AnimalSupressed;
use Mateu\Backend\History\Application\Create\HistoryCreator;

class GenerateHistoryWhenAnimalSupressed
{
    /**
     * @var HistoryCreator
     */
    private $historyCreator;

    public function __construct(HistoryCreator $historyCreator)
    {
        $this->historyCreator = $historyCreator;
    }

    public function __invoke(AnimalSupressed $supressed)
    {
        $this->historyCreator->create(
            $supressed->getAnimalId(),
            $supressed->getComment());
    }

}