<?php

namespace Mateu\Tests\Animal;

use Mateu\Backend\Race\Domain\Entity\Race;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class RaceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldAssertSameClass()
    {
        $r = new Race(Uuid::random(),'001', 'race1');
        $this->assertInstanceOf(Race::class, $r);
    }

}