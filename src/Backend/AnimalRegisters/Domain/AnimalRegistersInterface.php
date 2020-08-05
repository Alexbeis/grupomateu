<?php

namespace Mateu\Backend\AnimalRegisters\Domain;

use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\AnimalRegisters\Domain\Entity\AnimalRegisters;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;

interface AnimalRegistersInterface
{
    /**
     * @param AnimalRegisters $animalRegisters
     *
     * @return void
     */
    public function persist(AnimalRegisters $animalRegisters) : void;

    /**
     *
     * Check if an animal can Income to the system.
     *  - Never has been on the system
     *  - Before on the system but there was a moving or a fix (leave and income)
     * @param Animal $animal
     *
     * @return bool
     */
    public function canIncome(Animal $animal) : bool;

    /**
     *
     * Check if an animal can Leave from the system.
     * @param Animal $animal
     *
     * @return bool
     */
    public function canLeave(Animal $animal) : bool;

    /**
     * @param Animal $animal
     *
     * @return bool
     */
    public function exists(Animal $animal): bool;


}