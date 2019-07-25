<?php

namespace Mateu\Backend\Race\Domain;

use Mateu\Backend\Race\Domain\Entity\Race;

interface RaceRepositoryInterface
{
    public function save(Race $race);
    public function getAll();

}