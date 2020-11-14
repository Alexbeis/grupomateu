<?php

namespace Mateu\IncomingRegister\Domain;

use InvalidArgumentException;
use Mateu\Backend\IncomingRegister\Domain\CodeFromScanner;
use Mateu\Backend\IncomingRegister\Domain\InfoExtractor;
use PHPUnit\Framework\TestCase;

class InfoExtractorTest extends TestCase
{
    public function testBarcodeStringIsParsedSuccessfully()
    {
        $string = 'FR6505523676/22052014021142/FR6505523675';
        $codeFromScanner = new CodeFromScanner($string);

        list(
            $birthDate,
            $sex,
            $raceCode,
            $crotalRaw,
            $crotalRawMother
            ) = (new InfoExtractor($codeFromScanner))->extract();

        $this->assertEquals('FR6505523676', $crotalRaw);
        $this->assertEquals('FR6505523675', $crotalRawMother);
        $this->assertEquals('22052014', $birthDate->format('dmY'));
        $this->assertEquals('02', $sex);
        $this->assertEquals('1142', $raceCode);
    }

    /**
     * @dataProvider invalidBarCode
     */
    public function testInvalidBarCodeThrowsInvalidArgumentExeption($invalidBarCode)
    {
        $codeFromScanner = new CodeFromScanner($invalidBarCode);

        $this->expectException(InvalidArgumentException::class);

        list(
            $birthDate,
            $sex,
            $raceCode,
            $crotalRaw,
            $crotalRawMother
            ) = (new InfoExtractor($codeFromScanner))->extract();
    }

    public function invalidBarCode()
    {
        return [
            ['FR6505523676/2205201421142/FR6505523675']
            [null],
            [false],
            ['Holi']
        ];
    }
}