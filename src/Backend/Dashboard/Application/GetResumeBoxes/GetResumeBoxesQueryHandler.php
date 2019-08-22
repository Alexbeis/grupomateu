<?php

namespace Mateu\Backend\Dashboard\Application\GetResumeBoxes;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetResumeBoxesQueryHandler implements MessageHandlerInterface
{
    private $dashboardUseCase;

    public function __construct(SummaryDashboardUseCase $dashboardUseCase)
    {
        $this->dashboardUseCase = $dashboardUseCase;
    }

    public function __invoke(GetResumeBoxesQuery $resumeBoxesQuery)
    {
        return $this->dashboardUseCase->execute();
    }
}
