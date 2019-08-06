<?php

namespace Mateu\Backend\InType\Infraestructure\Controller;

use Mateu\Backend\InType\Application\Create\CreateInTypeCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddInTypeController
 * @package Mateu\Infraestructure\Controller\Configuration\InType
 * @IsGranted("ROLE_ADMIN")
 */
class AddInTypeController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     * @Route("configuration/in_type/add", name="add_intype", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $uuid =  Uuid::random()->getValue();

            $this->dispatch(
                new CreateInTypeCommand(
                    $uuid,
                    $request->get('intype_code'),
                    $request->get('intype_name')
                )
            );

        } catch (\Throwable $e) {
            $this->createFailResponse($e->getMessage());
        }

        return $this->createSuccessResponse('Tipo de Entrada creada correctamente');
    }
}
