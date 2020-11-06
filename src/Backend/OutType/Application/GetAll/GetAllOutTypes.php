<?php

namespace Mateu\Backend\OutType\Application\GetAll;

use Mateu\Backend\OutType\Infraestructure\OutTypeRepository;

class GetAllOutTypes
{
    /**
     * @var OutTypeRepository
     */
    private $outTypeRepository;

    public function __construct(OutTypeRepository $outTypeRepository)
    {
        $this->outTypeRepository = $outTypeRepository;
    }

    public function get()
    {
        $all = $this->outTypeRepository->findAll();
        $result = [];

        foreach ($all as $outType) {
            $result[] = [
                'id' => $outType->getId(),
                'name' => $outType->getName()
            ];
        }

        return $result;
    }
}