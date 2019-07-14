<?php

namespace Mateu\Infraestructure\Controller\Explotation;

use Mateu\Backend\Explotation\Application\Delete\DeleteExplotationCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteExplotationController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class DeleteExplotationController extends BaseController
{
    /**
     * @param $id
     *
     * @return JsonResponse
     * @Route("/explotation/delete/{id}", name="delete_explotation", requirements={"id"= "\d+"},
     *      methods={"DELETE"})
     *
     */
    public function __invoke($id)
    {
        //throw new NotEmptyExplotationException('oli oliii');
        $this->dispatch(
            new DeleteExplotationCommand($id)
        );

        return new JsonResponse(
            [
                'success' => true,
                'message' => 'Explotación borrada correctamente'
            ]
        );
    }
}