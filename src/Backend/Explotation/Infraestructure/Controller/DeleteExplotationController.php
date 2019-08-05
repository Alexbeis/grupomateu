<?php

namespace Mateu\Backend\Explotation\Infraestructure\Controller;

use Mateu\Backend\Explotation\Application\Delete\DeleteExplotationCommand;
use Mateu\Backend\Explotation\Application\Delete\NotEmptyExplotationException;
use Mateu\Backend\Explotation\Domain\ExplotationNotFound;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteExplotationController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class DeleteExplotationController extends BaseController implements ControllerInterface
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
        try {
            $this->dispatch(
                new DeleteExplotationCommand($id)
            );
        } catch (NotEmptyExplotationException $e) {
            return $this->createFailResponse($e->getMessage());
        } catch (ExplotationNotFound $e) {
            return $this->createFailResponse($e->getMessage());
        }

        return $this->createSuccessResponse('Explotación borrada correctamente');

    }
}