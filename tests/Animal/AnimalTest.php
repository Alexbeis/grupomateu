<?php

namespace Mateu\Tests\Animal;

use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use PHPUnit\Framework\TestCase;

class AnimalTest extends TestCase
{

    public function testSameAnimalClass()
    {
        $this->markTestSkipped();
        $animal = new Animal();
        $crot = (string)rand(1000000000, 9999999999);
        $crotMother = (string)rand(1000000000, 9999999999);
        $num = substr($crot, -4);
        $animal->setInternalNum($num);
        $animal->setCrotal($crot);
        $animal->setCrotalMother($crotMother);
        $animal->setProcedence('Morroco');
        $animal->setWeightIn(rand(10, 20));
        $date = new \DateTime();
        $date->modify('-' . rand(0, 10) . 'day');
        $animal->setBirthDate($date);
        $animal->setExplotation(new Explotation());

        $this->assertInstanceOf(Animal::class, $animal);

    }

    public function testSameCrotalNum()
    {
        $this->markTestSkipped();

        $animal = new Animal();
        $crot = (string) 9999999999;
        $crotMother = (string)rand(1000000000, 9999999999);
        $num = substr($crot, -4);
        $animal->setInternalNum($num);
        $animal->setCrotal($crot);
        $animal->setCrotalMother($crotMother);
        $animal->setProcedence('Morroco');
        $animal->setWeightIn(rand(10, 20));
        $date = new \DateTime();
        $date->modify('-' . rand(0, 10) . 'day');
        $animal->setBirthDate($date);
        $animal->setExplotation(new Explotation());

        $this->assertSame('9999999999', $animal->getCrotal());

    }

}
