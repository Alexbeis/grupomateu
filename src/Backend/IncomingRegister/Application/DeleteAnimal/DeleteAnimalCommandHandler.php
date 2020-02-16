<?php

namespace Mateu\Backend\IncomingRegister\Application\DeleteAnimal;

use Mateu\Shared\Domain\ValueObject\GenericId;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteAnimalCommandHandler implements MessageHandlerInterface
{
    /**
     * @var AnimalDeletor
     */
    private $animalDeletor;

    public function __construct(AnimalDeletor $animalDeletor)
    {
        $this->animalDeletor = $animalDeletor;
    }

    public function __invoke(DeleteAnimalCommand $animalCommand)
    {
        $incRegisterId  = new GenericId($animalCommand->getIncomingRegisterId());
        $animalId       = new GenericId($animalCommand->getAnimalId());

        $this->animalDeletor->delete($incRegisterId, $animalId);
    }
}