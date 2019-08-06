<?php

namespace Mateu\Backend\Notification\Infraestructure;

use Mateu\Backend\Notification\Application\Create\NotificationCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends BaseController
{
    /**
     * @Route("notification")
     * @IsGranted("ROLE_ADMIN")
     */
    public function __invoke()
    {
        $this->dispatch(
            new NotificationCommand('HELLO FROM MESSENGER', ['@BEIS', '@MORE'])
        );
    }
}