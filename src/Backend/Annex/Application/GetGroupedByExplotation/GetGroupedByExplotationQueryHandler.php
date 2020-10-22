<?php

namespace Mateu\Backend\Annex\Application\GetGroupedByExplotation;

use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetGroupedByExplotationQueryHandler implements MessageHandlerInterface
{
    /**
     * @var AnnexRepositoryInterface
     */
    private $annexRepository;

    public function __construct(AnnexRepositoryInterface $annexRepository)
    {
        $this->annexRepository = $annexRepository;
    }

    public function __invoke(GetGroupedByExplotationQuery $byExplotationQuery)
    {
        return $this->annexRepository->getGroupedByExplotation();
    }
}