<?php

namespace Mateu\Backend\InType\Application\GetAll;

use Mateu\Backend\InType\Infraestructure\InTypeRepository;

final class GetAllInTypes
{
    /**
     * @var InTypeRepository
     */
    private $inTypeRepository;

    public function __construct(InTypeRepository $inTypeRepository)
    {
        $this->inTypeRepository = $inTypeRepository;
    }

    public function get()
    {
        $all = $this->inTypeRepository->findAll();

        $result = [];

        foreach ($all as $intype) {
            $result[] = [
                'id' => $intype->getId(),
                'name' => $intype->getName()
            ];
        }

        return $result;

    }

}