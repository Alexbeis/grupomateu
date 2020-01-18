<?php

namespace Mateu\Backend\Export\Infrastructure\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IncomingRegistersController
 * @package Mateu\Backend\IncomingRegister\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class TestExportController extends BaseController implements ControllerInterface
{
    /**
     * @Route(
     *     "/export/{uuid}.{_format}",
     *     name="index_export",
     *     format="pdf",
     *     methods={"GET"},
     *     requirements={
     *         "_format": "pdf|csv",
     *     }
     *)
     * @param Request $request
     * @param $uuid
     * @param $_format
     *
     * @return PdfResponse
     */
    public function __invoke(Request $request , Pdf $snappy, $uuid ,$_format)
    {
        return new PdfResponse(
            $snappy->getOutputFromHtml(
                '<h1>Test</h1><div>Test!!!</div>'
            ),
            sprintf('%s.pdf', $uuid)
        );
    }

}