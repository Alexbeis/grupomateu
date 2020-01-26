<?php

namespace Mateu\Backend\IncomingRegister\Domain;

use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;

interface IncomingRegisterRepositoryInterface
{
    public function save(IncomingRegister $incomingRegister);
}