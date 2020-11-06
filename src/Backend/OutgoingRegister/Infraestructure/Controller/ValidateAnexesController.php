<?php

namespace Mateu\Backend\OutgoingRegister\Infraestructure\Controller;

use Exception;
use Mateu\Backend\OutgoingRegister\Application\Validation\OutgoingAnimalValidation;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostOutgoingRegisterController
 * @IsGranted("ROLE_ADMIN")
 */
class ValidateAnexesController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @param OutgoingAnimalValidation $animalValidation
     *
     * @return JsonResponse
     * @Route(
     *     {
     *     "en": "/outgoing-registers/validate/"
     *      },
     *     name = "out_register_validation",
     *     methods={"GET"}
     *     )
     */
    public function __invoke(Request $request, OutgoingAnimalValidation $animalValidation)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->createFailResponse('No xmlHttpRequest here :)');
        }
        $expcode = $request->get('expcode');

        $result = $animalValidation->validate($expcode);

        return $this->createSuccessResponse('Validacion finalizada', $result);
    }

}