<?php

namespace Mateu\Backend\Race\Infraestructure\Controller;

use Mateu\Backend\Race\Application\Create\CreateRaceCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddRaceController
 * @package Mateu\Backend\Race\Infraestructure
 * @IsGranted("ROLE_ADMIN")
 */
class AddRaceController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("configuration/race/add", name="add_race", methods={"POST"})
     *
     */
    public function __invoke(Request $request)
    {
        try {
            $uuid =  Uuid::random()->getValue();

            $this->dispatch(
                new CreateRaceCommand(
                    $uuid,
                    $request->get('race_code'),
                    $request->get('race_name')
                )
            );

        }  catch (HandlerFailedException $e) {
            return $this->createFailResponse($e->getMessage());
        } catch (\Exception $e) {
            return $this->createFailResponse($e->getMessage());
        }

        return $this->createSuccessResponse('Raza creada correctamente');
    }
}