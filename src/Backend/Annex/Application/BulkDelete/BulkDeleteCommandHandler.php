<?php

namespace Mateu\Backend\Annex\Application\BulkDelete;

use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class BulkDeleteCommandHandler implements MessageHandlerInterface
{
    /**
     * @var AnnexRepositoryInterface
     */
    private $annexRepository;

    public function __construct(AnnexRepositoryInterface $annexRepository)
    {
        $this->annexRepository = $annexRepository;
    }

    public function __invoke(BulkDeleteCommand $deleteCommand)
    {
        $this->annexRepository->deleteAnnexedByExplotationCode($deleteCommand->getExpCode());
    }

}