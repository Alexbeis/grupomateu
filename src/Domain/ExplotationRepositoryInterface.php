<?php

namespace App\Domain;

interface ExplotationRepositoryInterface
{
    public function save($explotation);
    public function getTotal();
    public function remove($explotation);
}