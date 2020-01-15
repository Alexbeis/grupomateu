<?php

namespace Mateu\Backend\Animal\Application\GetAll;

use Mateu\Backend\Animal\Domain\AnimalRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAnimalsQueryHandler implements MessageHandlerInterface
{
    /**
     * @var AnimalRepository
     */
    private $animalRepository;

    public function __construct(AnimalRepository $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    public function __invoke(GetAnimalsQuery $animalsQuery)
    {
        return $this->animalRepository->findAll();
    }
}
