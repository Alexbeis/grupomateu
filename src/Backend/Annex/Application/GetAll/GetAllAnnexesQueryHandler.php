<?php

namespace Mateu\Backend\Annex\Application\GetAll;

use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAllAnnexesQueryHandler implements MessageHandlerInterface
{
    private $annexRepository;

    public function __construct(AnnexRepositoryInterface $annexRepository)
    {
        $this->annexRepository = $annexRepository;
    }

    public function __invoke(GetAllAnnexesQuery $allAnnexesQuery)
    {
        return $this->annexRepository->findAll();
    }
}
