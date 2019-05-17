<?php

namespace App\Domain;

interface ExplotationRepositoryInterface
{
    public function save();
    public function getTotal();
}