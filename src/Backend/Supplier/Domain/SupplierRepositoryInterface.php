<?php

namespace Mateu\Backend\Supplier\Domain;

interface SupplierRepositoryInterface
{
    public function save();
    public function getTotal();

}