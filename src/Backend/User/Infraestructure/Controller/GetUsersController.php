<?php

namespace Mateu\Backend\User\Infraestructure\Controller;

use Mateu\Backend\User\Infraestructure\UserRepository;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class GetUsersController extends BaseController implements ControllerInterface
{
    /**
     * @Route("users", name="index_users", methods={"GET"})
     *
     */
    public function __invoke( UserRepository $userRepository)
    {

        return new Response(
            $this->renderView(
                'users/index.html.twig',
                [
                    'users' => $userRepository->findAll()
                ]
            )
        );
    }

}