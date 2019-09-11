<?php

namespace Mateu\Backend\Annex\Infraestructure\Controller;

use Mateu\Backend\Annex\Application\Create\CreateAnnexCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@IsGranted("ROLE_ADMIN")
 */
class CreateAnnexController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @Route("/annex/create", name="annex_create", methods={"POST"}, options = { "expose" = true })
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $this->dispatch(
            new CreateAnnexCommand(
                $request->request->get('id')
            )
        );
        return $this->json('ok');
    }

}