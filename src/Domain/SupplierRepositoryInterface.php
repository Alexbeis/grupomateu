<?php

namespace App\Domain;

interface SupplierRepositoryInterface
{
    public function save();
    public function getTotal();

}