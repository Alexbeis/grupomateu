<?php

namespace Mateu\Backend\Annex\Application\BulkDelete;

class BulkDeleteCommand
{
    private $expCode;

    public function __construct($expCode)
    {
        $this->expCode = $expCode;
    }

    /**
     * @return mixed
     */
    public function getExpCode()
    {
        return $this->expCode;
    }
}
