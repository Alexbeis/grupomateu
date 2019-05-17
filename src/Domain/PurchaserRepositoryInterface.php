<?php

namespace App\Domain;

interface PurchaserRepositoryInterface
{
    public function save();
    public function getTotal();

}