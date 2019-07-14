<?php

namespace Mateu\Backend\Explotation\Application\Delete;

class ExplotationDeleted
{
    private $code;
    private $createdBy;

    public function __construct($code, $createdBy)
    {
        $this->code = $code;
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}