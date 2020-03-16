<?php

namespace Mateu\Backend\Annex\Application\GetByCriteria;

use Doctrine\Common\Collections\Criteria;
use Mateu\Backend\Annex\Infraestructure\AnnexRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetByCriteriaQueryHandler implements MessageHandlerInterface
{
    /**
     * @var AnnexRepository
     */
    private $annexRepository;

    public function __construct(AnnexRepository $annexRepository)
    {
        $this->annexRepository = $annexRepository;
    }

    public function __invoke(GetByCriteriaQuery $criteriaQuery)
    {
        $criteria = Criteria::create();
        $expr = Criteria::expr();

        $criteria->andWhere(
            $expr->in('id', $criteriaQuery->getIds())
        );

        return $this->annexRepository->matching($criteria);
    }
}