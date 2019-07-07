<?php

namespace Mateu\Backend\Animal\Domain;

interface AnimalRepositoryInterface
{
    public function save();
    public function getTotal();

}