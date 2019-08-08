<?php

namespace Mateu\Backend\Animal\Application\GetAll;

use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAnimalsQueryHandler implements MessageHandlerInterface
{
    /**
     * @var AnimalRepositoryInterface
     */
    private $animalRepository;

    public function __construct(AnimalRepositoryInterface $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    public function __invoke(GetAnimalsQuery $animalsQuery)
    {
        return $this->animalRepository->findAll();
    }
}
