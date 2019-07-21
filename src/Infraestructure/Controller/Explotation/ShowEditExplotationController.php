<?php

namespace Mateu\Infraestructure\Controller\Explotation;

use Mateu\Backend\Explotation\Application\Find\ExplotationFinder;
use Mateu\Infraestructure\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShowEditExplotationController
 * @package Mateu\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class ShowEditExplotationController extends BaseController
{
    /**
     * @Route("/explotation/edit/{id}", name="edit_explotation", methods={"GET"}, requirements={"id"= "\d+"})
     * @param $id
     * @param ExplotationFinder $explotationFinder
     *
     * @return void
     */
    public function __invoke($id, ExplotationFinder $explotationFinder)
    {
        // TODO: control exceptions from finder
        $explotation = $explotationFinder->__invoke($id);

        return new Response(
            $this->render('explotations/explotation/index.html.twig',
                ['explotation' => $explotation]
            )
        );
    }

}