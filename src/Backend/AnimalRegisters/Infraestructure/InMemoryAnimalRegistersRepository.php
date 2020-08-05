<?php

namespace Mateu\Backend\AnimalRegisters\Infraestructure;

use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\AnimalRegisters\Domain\AnimalRegistersInterface;
use Mateu\Backend\AnimalRegisters\Domain\Entity\AnimalRegisters;

class InMemoryAnimalRegistersRepository implements AnimalRegistersInterface
{
    private $data = [];

    public function persist(AnimalRegisters $animalRegisters):void
    {
        $this->data[$animalRegisters->getCrotal()][] = $animalRegisters;
    }

    public function canIncome(Animal $animal): bool
    {
        $canIncome = true;

        if (!$this->exists($animal)) {
            return $canIncome;
        }

        /**
         * @var AnimalRegisters $animalRegister
         */
        foreach ($this->data as $id => $animalRegisters) {

            foreach ($animalRegisters as $ar) {
                if ($ar->getCrotal() == $animal->getCrotal() &&
                    !is_null($ar->getIncomingRegisterUuid()) &&
                    is_null($ar->getOutgoingRegisterUuid())) {

                    $canIncome = false;
                }
            }
        }

        return $canIncome;
    }

    public function canLeave(Animal $animal):bool
    {
        $canIncome = true;

        if (!$this->exists($animal)) {
            return !$canIncome;
        }

        /**
         * @var AnimalRegisters $animalRegister
         */
        foreach ($this->data as $id => $animalRegisters) {

            foreach ($animalRegisters as $ar) {
                if ($ar->getCrotal() == $animal->getCrotal() &&
                    !is_null($ar->getIncomingRegisterUuid()) &&
                    !is_null($ar->getOutgoingRegisterUuid())) {

                    $canIncome = false;
                }
            }
        }

        return $canIncome;
    }

    public function exists(Animal $animal): bool
    {
        return array_key_exists($animal->getCrotal(), $this->data);

    }
}