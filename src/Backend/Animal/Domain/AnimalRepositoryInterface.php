<?php

namespace Mateu\Backend\Animal\Domain;

use Mateu\Backend\Animal\Domain\Entity\Animal;

interface AnimalRepositoryInterface
{
    public function save(Animal $animal);
    public function getTotal();

}