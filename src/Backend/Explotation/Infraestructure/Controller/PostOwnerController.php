<?php

namespace Mateu\Backend\Explotation\Infraestructure\Controller;

use Mateu\Backend\Explotation\Application\PostOwner\OwnerCreator;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostOwnerController
 * @package Mateu\Backend\Explotation\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class PostOwnerController extends BaseController implements ControllerInterface
{

    /**
     * @Route("/explotation/owner/", name="save_owner", methods={"POST"})
     * @param Request $request
     *
     * @param OwnerCreator $ownerCreator
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, OwnerCreator $ownerCreator)
    {
        $content = $request->request->all();
        $ownerCreator($content);

        return new RedirectResponse(
            $this->router->generate(
                'edit_explotation',
                [
                    'id' => $content['exp_id']
                ]
            )
        );
    }

}