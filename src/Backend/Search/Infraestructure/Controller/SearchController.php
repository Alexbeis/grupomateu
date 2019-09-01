<?php

namespace Mateu\Backend\Search\Infraestructure\Controller;

use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class SearchController extends BaseController implements ControllerInterface
{
    /**
     * @Route("search", name="index_search", methods={"GET"})
     */
    public function __invoke()
    {
        return new Response(
            $this->render('search/index-search.html.twig', [] )
        );
    }

}