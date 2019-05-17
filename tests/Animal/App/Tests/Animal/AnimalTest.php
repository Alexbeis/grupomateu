<?php
/**
 * Created by PhpStorm.
 * User: AlexYAloha
 * Date: 23/04/2019
 * Time: 20:23
 */

namespace App\Tests\Animal;


use App\Domain\Entity\Animal;
use App\Domain\Entity\Explotation;



class AnimalTest extends \PHPUnit_Framework_TestCase
{
    public function testSameAnimalClass()
    {
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
