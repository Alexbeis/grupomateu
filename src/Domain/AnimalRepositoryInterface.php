<?php


namespace App\Domain;

interface AnimalRepositoryInterface
{
    public function save();
    public function getTotal();

}