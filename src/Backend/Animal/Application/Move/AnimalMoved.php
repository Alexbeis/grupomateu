<?php

namespace Mateu\Backend\Animal\Application\Move;

class AnimalMoved
{
    private $from;
    private $to;
    private $animalId;

    public function __construct($from, $to, $animalId)
    {
        $this->from = $from;
        $this->to = $to;
        $this->animalId = $animalId;
    }

    /**
     * @return mixed
     */
    public function getAnimalId()
    {
        return $this->animalId;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }
}

