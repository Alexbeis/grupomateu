<?php

namespace Mateu\Backend\Animal\Application\PostSupression;

use DateTime;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PostAnimalSupressionCommandHandler implements MessageHandlerInterface
{
    /**
     * @var SupressAnimal
     */
    private $supressAnimal;

    public function __construct(SupressAnimal $supressAnimal)
    {
        $this->supressAnimal = $supressAnimal;
    }

    public function __invoke(PostAnimalSupressionCommand $postAnimalSupressionCommand)
    {
        $this->supressAnimal->supress(
            $postAnimalSupressionCommand->getAnimalId(),
            $postAnimalSupressionCommand->getDays(),
            $postAnimalSupressionCommand->getProduct(),
            new DateTime($postAnimalSupressionCommand->getSupressionDate())
        );
    }
}