<?php

namespace Mateu\AnimalRegisters\Infraestructure;

use Mateu\AnimalRegisters\Domain\AnimalRegistersInterfaceTest;
use Mateu\Backend\AnimalRegisters\Domain\AnimalRegistersInterface;
use Mateu\Backend\AnimalRegisters\Infraestructure\InMemoryAnimalRegistersRepository;

class InMemoryAnimalsRegisterInterfaceTest extends AnimalRegistersInterfaceTest
{
    function getRepository(): AnimalRegistersInterface
    {
        return new InMemoryAnimalRegistersRepository();
    }
}