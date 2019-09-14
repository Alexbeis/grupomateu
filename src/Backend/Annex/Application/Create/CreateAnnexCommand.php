<?php

namespace Mateu\Backend\Annex\Application\Create;

class CreateAnnexCommand
{
    private $animal_id;

    public function __construct($animal_id)
    {
        $this->animal_id = $animal_id;
    }

    /**
     * @return mixed
     */
    public function getAnimalId()
    {
        return $this->animal_id;
    }
}