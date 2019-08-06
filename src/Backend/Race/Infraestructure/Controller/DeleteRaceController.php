<?php

namespace Mateu\Backend\Race\Infraestructure\Controller;

use Mateu\Backend\Race\Application\Delete\DeleteRaceCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteRaceController
 * @package Mateu\Infraestructure\Controller\Configuration\Race
 * @IsGranted("ROLE_ADMIN")
 */
class DeleteRaceController extends BaseController
{
    /**
     * @param $id
     *
     * @return JsonResponse
     * @Route("configuration/race/delete/{id}", name="delete_race", methods={"GET"})
     *
     */
    public function __invoke($id)
    {
        try {
            $this->dispatch(
                new DeleteRaceCommand(
                    $id
                )
            );

        } catch (\Throwable $e) {
            $this->createFailResponse($e->getMessage());
        } catch (\PDOException $e) {
            $this->createFailResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->createFailResponse($e->getMessage());
        }

        return $this->createSuccessResponse('Raza Eliminada correctamente');


    }

}