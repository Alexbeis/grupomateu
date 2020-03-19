<?php

namespace Mateu\Backend\Animal\Application\PostSupression;

class AnimalSupressed
{
    private $animalId;

    private $comment;

    public function __construct($animalId, $comment)
    {
        $this->animalId = $animalId;
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getComment():string
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getAnimalId():int
    {
        return $this->animalId;
    }

}