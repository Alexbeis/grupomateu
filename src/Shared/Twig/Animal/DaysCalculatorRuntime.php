<?php

namespace Mateu\Shared\Twig\Animal;

use Mateu\Backend\Animal\Domain\BirthdayDaysCalculator;
use Twig\Extension\RuntimeExtensionInterface;

class DaysCalculatorRuntime implements RuntimeExtensionInterface
{
    private $calculator;

    public function __construct(BirthdayDaysCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function calculateDaysAge($date)
    {
        return $this->calculator->getDaysAge($date);
    }
}