<?php

namespace Mateu\Tests\Service;

use DateTime;
use Mateu\Domain\Service\Animal\Birthday\BirthdayMonthCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class BirthdayMonthCalculatorTest
 * It Tests birthdayMonthCalculator to get how many month from today
 * Dates represents animal birthdates
 * @package App\Tests\UseCases
 */
class BirthdayMonthCalculatorTest extends TestCase
{
    public function getBirthDates()
    {
        return [
            [2018, 1, 1, 18],
            [2019, 4, 1, 3],
            [2017, 1, 1, 30],
            [2018, 12, 1, 7]
        ];
    }

    /**
     * @dataProvider getBirthDates
     */
    public function testItReturnsCorrectMonthAge($year, $month, $day, $result)
    {
        $birthdate = new DateTime();
        $birthdate->setDate($year, $month, $day);
        $calculator = new BirthdayMonthCalculator($birthdate->format('Y-m-d'));
        $months = $calculator->getMonthAge('NOW');

        $this->assertEquals($result, $months);


    }

}