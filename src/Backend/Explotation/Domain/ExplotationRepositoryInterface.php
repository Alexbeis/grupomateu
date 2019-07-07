<?php

namespace Mateu\Backend\Explotation\Domain;

interface ExplotationRepositoryInterface
{
    public function save($explotation);
    public function getTotal();
    public function remove($explotation);
}