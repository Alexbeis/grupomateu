<?php

namespace Mateu\Backend\Annex\Application\GetByCriteria;

class GetByCriteriaQuery
{
    private $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }
}