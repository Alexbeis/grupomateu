<?php

namespace Mateu\Infraestructure\Controller\Configuration\InType;

use Mateu\Backend\InType\Application\GetAll\GetAllInTypes;
use Mateu\Infraestructure\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class GetInTypesController
 * @IsGranted("ROLE_ADMIN")
 */
class GetInTypesController extends BaseController
{
    /**
     * @param GetAllInTypes $allInTypes
     *
     * @return JsonResponse
     * @Route("configuration/in_types/get", name="intypes_get", methods={"GET"})
     */
    public function __invoke(GetAllInTypes $allInTypes)
    {
        return new JsonResponse(
            $allInTypes->get()
        );
    }

}