<?php

namespace Mateu\Shared\Twig\Animal;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MonthCalculator extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('calculateMonths', [MonthCalculatorRuntime::class, 'calculateMonthsAge']),
        ];
    }
}