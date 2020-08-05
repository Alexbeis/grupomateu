<?php

namespace Mateu\AnimalRegisters\Domain;

use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\AnimalRegisters\Domain\AnimalRegistersInterface;
use Mateu\Backend\AnimalRegisters\Domain\Entity\AnimalRegisters;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;
use PHPUnit\Framework\TestCase;


abstract class AnimalRegistersInterfaceTest extends TestCase
{
    private $repo;

    abstract function getRepository() : AnimalRegistersInterface;

    public function setUp()
    {
        $this->repo = $this->getRepository();
    }

    protected function tearDown()
    {
        $this->repo = null;
    }

    public function testAnimalCanNotIncomeToTheSystem()
    {
        $uuid = Uuid::random();

        $animal = (new Animal())
            ->setCrotal('ES898989898');

        $animalRegister = (new AnimalRegisters())
            ->setCrotal($animal->getCrotal())
            ->setIncomingRegisterUuid($uuid);

        $this->repo->persist($animalRegister);

        $this->assertFalse($this->repo->canIncome($animal));
    }

    public function testAnimalCanIncomeToTheSystem()
    {
        $uuid = Uuid::random();

        $animal = (new Animal())
            ->setCrotal('ES898989898');

        $this->assertTrue($this->repo->canIncome($animal));

        $animalRegister = (new AnimalRegisters())
            ->setCrotal('ES898989898')
            ->setIncomingRegisterUuid($uuid)
            ->setOutgoingRegisterUuid($uuid);

        $this->repo->persist($animalRegister);

        $this->assertTrue($this->repo->canIncome($animal));
    }

    public function testAnimalCanNotLeaveToTheSystem()
    {
        $uuid = Uuid::random();

        $animal = (new Animal())
            ->setCrotal('ES898989898');

        $animalRegister = (new AnimalRegisters())
            ->setCrotal($animal->getCrotal())
            ->setIncomingRegisterUuid($uuid)
            ->setOutgoingRegisterUuid($uuid);

        $this->repo->persist($animalRegister);

        $this->assertFalse($this->repo->canLeave($animal));
    }

    public function testAnimalCanLeaveToTheSystem()
    {
        $uuid = Uuid::random();

        $animal = (new Animal())
            ->setCrotal('ES898989898');

        $animalRegister = (new AnimalRegisters())
            ->setCrotal($animal->getCrotal())
            ->setIncomingRegisterUuid($uuid);

        $this->repo->persist($animalRegister);

        $this->assertTrue($this->repo->canLeave($animal));
    }
}