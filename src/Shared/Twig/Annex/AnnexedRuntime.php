<?php

namespace Mateu\Shared\Twig\Annex;

use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Twig\Extension\RuntimeExtensionInterface;

class AnnexedRuntime implements RuntimeExtensionInterface
{
    private $annexRepository;

    public function __construct(AnnexRepositoryInterface $annexRepository)
    {
        $this->annexRepository = $annexRepository;
    }

    public function alreadyAnnexed($crotal)
    {
        return $this->annexRepository->exists($crotal);
    }
}