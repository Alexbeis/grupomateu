<?php

namespace Mateu\Backend\Explotation\Application\Delete;

class DeleteExplotationCommand
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}