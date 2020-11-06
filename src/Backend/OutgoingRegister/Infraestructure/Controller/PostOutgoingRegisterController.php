<?php

namespace Mateu\Backend\OutgoingRegister\Infraestructure\Controller;

use Exception;
use Mateu\Backend\OutgoingRegister\Application\Create\CreateOutgoingRegisterCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostOutgoingRegisterController
 * @IsGranted("ROLE_ADMIN")
 */
class PostOutgoingRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @Route(
     *     {
     *     "en": "/outgoing-registers/create/"
     *      },
     *     name = "out_register_create",
     *     methods={"POST"}
     *     )
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->createFailResponse('No xmlHttpRequest here :)');
        }
        $uuid = Uuid::random()->getValue();
        $expcode = $request->get('expCode');

        try {
            $this->dispatch(
                new CreateOutgoingRegisterCommand(
                    $expcode,
                    $uuid
                )
            );
        } catch (Exception $e) {
            return $this->createFailResponse(
                $e->getMessage()
            );
        }

        return $this->createSuccessResponse(
            'Creado, redireccionando hacia el registro de salida',
            ['uuid' => $uuid]
        );

    }

}