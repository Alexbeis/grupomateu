<?php

namespace Mateu\Infraestructure\Controller\Configuration;

use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConfigurationController
 * @package Mateu\Infraestructure\Controller\Configuration
 * @IsGranted("ROLE_ADMIN")
 */
class IndexConfigurationController extends BaseController
{
    /**
     * @Route("configuration", name="index_conf", methods={"GET"})
     */
    public function __invoke()
    {
        return new Response($this->render('configuration/index.html.twig'));
    }

}