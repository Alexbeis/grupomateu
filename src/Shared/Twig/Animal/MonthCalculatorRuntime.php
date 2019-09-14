<?php

namespace Mateu\Shared\Twig\Animal;

use Mateu\Backend\Animal\Domain\BirthdayMonthCalculator;
use Twig\Extension\RuntimeExtensionInterface;

class MonthCalculatorRuntime implements RuntimeExtensionInterface
{
    private $calculator;

    public function __construct(BirthdayMonthCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function calculateMonthsAge($date)
    {
        return $this->calculator->getMonthAge($date);

    }

}