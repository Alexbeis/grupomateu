<?php

namespace Mateu\Shared\Twig\Annex;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Annexed extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('isAnnexed', [AnnexedRuntime::class, 'alreadyAnnexed']),
        ];
    }
}