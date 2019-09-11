<?php

namespace Mateu\Backend\Annex\Domain;

use Mateu\Backend\Annex\Domain\Entity\Annex;

interface AnnexRepositoryInterface
{
    public function save(Annex $annex);
    public function getTotals();
    public function exists(string $crotal);
}