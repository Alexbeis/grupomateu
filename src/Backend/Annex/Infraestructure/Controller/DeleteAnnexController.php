<?php

namespace Mateu\Backend\Annex\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@IsGranted("ROLE_ADMIN")
 */
class DeleteAnnexController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @Route("/annex/delete", name="annex_delete", methods={"DELETE"}, options = { "expose" = true })
     */
    public function __invoke(Request $request)
    {
        return $this->json('ok');
    }

}