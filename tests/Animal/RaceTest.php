<?php

namespace App\Tests\Animal;

use App\Domain\Entity\Race;
use PHPUnit\Framework\TestCase;

class RaceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldAssertSameClass()
    {
        $r = new Race('001', 'race1');
        $this->assertInstanceOf(Race::class, $r);
    }

}