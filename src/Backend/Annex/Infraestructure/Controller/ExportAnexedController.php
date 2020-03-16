<?php

namespace Mateu\Backend\Annex\Infraestructure\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Mateu\Backend\Annex\Application\GetByCriteria\GetByCriteriaQuery;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
     * @param SerializerInterface $serializer
     * @param $_format
     *
     * @return PdfResponse|Response
     * @throws \Exception
     */
    public function __invoke(Request $request ,Pdf $snappy, SerializerInterface $serializer, $_format)
    {
        $contentIds = $request->get('id');

        $envelope = $this->ask(
            new GetByCriteriaQuery($contentIds)
        );

        $handled = $envelope->last(HandledStamp::class);

        $timestamp = (new \DateTime('now'))->format('dmyyhms');

        if ($_format == 'pdf') {

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
        } else {
           $result = $handled->getResult()->map(function ($anex) {
               $animal = $anex->getAnimal();
               return [
                   'crotal' =>$animal->getCrotal(),
                   'Numero Interno' => $animal->getInternalNum(),
                   'Nacimiento' => $animal->getBirthDate()->format('d-m-Y'),
                   'Explotación' => $animal->getExplotation()->getName()
               ];
           })->toArray();

            $response = new Response(
                $serializer->serialize(
                    $result,
                    'csv'
                )
            );
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set(
                'Content-Disposition',
                'attachment; filename="'. sprintf('anexados_%s.csv', $timestamp).'"');

            return $response;
        }
    }

}