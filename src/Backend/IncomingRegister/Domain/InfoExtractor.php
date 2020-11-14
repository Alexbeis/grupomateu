<?php

namespace Mateu\Backend\IncomingRegister\Domain;

use InvalidArgumentException;

/**
 * Extracts all info given on an string from scanner
 *
 * Example:
 * "FR6505523676/22052014021142/FR6505523675"
 * Extracts:
 *  - crotal:FR6505523676
 *  - mixed:
 *      - birthdate: 22052014
 *      - sex: 2
 *      - raceCode: 1142
 *  - crotalMother:FR6505523675
 *
 */
class InfoExtractor
{
    const SEPARATOR = '/';

    /**
     * @var CodeFromScanner
     */
    private $codeFromScanner;

    public function __construct(CodeFromScanner $codeFromScanner)
    {
        if (empty($codeFromScanner->value())) {
            throw new InvalidArgumentException();
        }
        $this->codeFromScanner = $codeFromScanner;
    }

    public function extract()
    {
        list($crotalRaw, $mixed, $crotalRawMother) = $this->getFirstStep();

        preg_match('/([0-9-a-zA-Z]{8})([0-9-a-zA-Z]{2})([0-9-a-zA-Z]{4})/', $mixed, $output);

        if (!$output) {
            throw new InvalidArgumentException(sprintf('Error extrayendo %s', $this->codeFromScanner->value()));
        }

        $stringDate = $output[1];
        $sex = $output[2];
        $raceCode = $output[3];

        list($day, $month, $year) = TimeIntervalExtractor::fromString($stringDate);

        $birthDate = (new \DateTime())
            ->setDate($year, $month, $day);

        return [$birthDate, $sex, $raceCode, $crotalRaw, $crotalRawMother];
    }

    private function getFirstStep()
    {
        var_dump(explode(self::SEPARATOR, $this->codeFromScanner->value()));
        return explode(self::SEPARATOR, $this->codeFromScanner->value());
    }
}