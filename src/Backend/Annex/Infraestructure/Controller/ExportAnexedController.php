<?php

namespace Mateu\Backend\Annex\Infraestructure\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Mateu\Backend\Annex\Application\GetByCriteria\GetByCriteriaQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IncomingRegistersController
 * @package Mateu\Backend\IncomingRegister\Infraestructure\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class ExportAnexedController extends BaseController implements ControllerInterface
{
    /**
     * @Route(
     *     "/export/anexed/.{_format}",
     *     name="export_annexed",
     *     format="pdf",
     *     methods={"GET"},
     *     requirements={
     *         "_format": "pdf|csv",
     *     }
     *)
     * @param Request $request
     * @param Pdf $snappy
     * @param $_format
     *
     * @return PdfResponse
     * @throws \Exception
     */
    public function __invoke(Request $request ,Pdf $snappy, $_format)
    {
        $contentIds = $request->get('id');

        $envelope = $this->ask(
            new GetByCriteriaQuery($contentIds)
        );

        $handled = $envelope->last(HandledStamp::class);

        $timestamp = (new \DateTime('now'))->format('dmyyhms');

        return new PdfResponse(
            $snappy->getOutputFromHtml(
                $this->renderView(
                    'exports/anex/anexed-animals.twig',
                    [
                        'anexed' => $handled->getResult()
                    ]
                )
            ),
            sprintf('anexados_%s.pdf', $timestamp)
        );
    }

}