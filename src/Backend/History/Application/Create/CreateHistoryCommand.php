<?php

namespace Mateu\Backend\History\Application\Create;

class CreateHistoryCommand
{
    private $animal_id;
    private $comment;

    public function __construct($animal_id, $comment)
    {
        $this->animal_id = $animal_id;
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getAnimalId()
    {
        return $this->animal_id;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }
}
