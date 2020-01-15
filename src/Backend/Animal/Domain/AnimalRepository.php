<?php

namespace Mateu\Backend\Animal\Domain;

interface AnimalRepository
{
    public function save();
    public function getTotal();

}