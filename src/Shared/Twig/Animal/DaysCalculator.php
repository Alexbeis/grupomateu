<?php

namespace Mateu\Shared\Twig\Animal;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DaysCalculator extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('calculateDays', [DaysCalculatorRuntime::class, 'calculateDaysAge']),
        ];
    }

}