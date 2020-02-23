<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure\Controller;

use Mateu\Backend\IncomingRegister\Application\DeleteAnimal\DeleteAnimalCommand;
use Mateu\Infraestructure\Controller\BaseController;
use Mateu\Infraestructure\Controller\ControllerInterface;
use Mateu\Infraestructure\Result\FailApiResult;
use Mateu\Infraestructure\Result\SuccessApiResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;

class DeleteCrotalFromIncomigRegisterController extends BaseController implements ControllerInterface
{
    /**
     * @param Request $request
     *
     * @Route(
     *     {
     *     "es": "/registros/entrada/borrar-crotal",
     *     "en": "/incoming/registers/delete-crotal"
     * },
     *     name = "register_delete_crotal",
     *     methods={"DELETE"}
     * )
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        try {
           $this->dispatch(
               new DeleteAnimalCommand(
                   $content['incRegister'],
                   $content['animalId']
               )
           );

        } catch (HandlerFailedException $e) {
            return
                (new Response())
                    ->setContent(
                        new FailApiResult(
                            [
                                'data' => $content
                            ],
                            $e->getMessage()
                        )
                    );
        }

        return
            (new Response())
                ->setContent(
                    new SuccessApiResult(
                        [
                            'data' => $content
                        ]
                    )
                );

    }

}