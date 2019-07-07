<?php

namespace Mateu\Backend\Purchaser\Domain;

interface PurchaserRepositoryInterface
{
    public function save();
    public function getTotal();

}