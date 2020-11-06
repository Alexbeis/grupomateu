<?php

namespace Mateu\Backend\OutgoingRegister\Application\Validation;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Animal\Domain\Entity\Supression;
use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Mateu\Backend\OutgoingRegister\Infraestructure\OutgoingRegisterRepository;
use Mateu\Shared\Application\Validation\ExecutionContext;
use Mateu\Shared\Application\Validation\Violation;
use Symfony\Component\Workflow\Registry;

class OutgoingAnimalValidation
{
    private $annexRepository;

    private $entityManager;

    private $outgoingRegisterRepository;

    private $workflow;

    public function __construct(
        AnnexRepositoryInterface $annexRepository,
        EntityManagerInterface $entityManager,
        OutgoingRegisterRepository $outgoingRegisterRepository,
        Registry $workflow
    ) {
        $this->annexRepository = $annexRepository;
        $this->entityManager = $entityManager;
        $this->outgoingRegisterRepository = $outgoingRegisterRepository;
        $this->workflow = $workflow;
    }

    public function validate($expCode)
    {
        $context = new ExecutionContext();
        $supressedAnimals = $this->annexRepository->existsSupressedByExplotation($expCode);
        $annexedAnimals = $this->annexRepository->getAnnexedAnimalsByExplotationCode($expCode);

        foreach ($supressedAnimals as $supressedAnimal) {
            /**
             * @var Animal $animal
             */
            $animal = $supressedAnimal->getAnimal();
            $supressed = $animal->getSupression();
            if ($supressed && !$this->canGoOutBySupression($supressed)) {
                $context->addViolation(
                    new Violation(
                        'Crotal %s esta bajo supression',
                        [$animal->getCrotal()]
                    )
                );
            }
        }

        foreach ($annexedAnimals as $annexed) {

            /**
             * @var Animal $animal
             */
            $animal = $annexed->getAnimal();
            $animalStateMachine = $this->workflow->get($animal);
            $canGouOut = $animalStateMachine->can($animal, 'to_outgoing');

            if (!$canGouOut) {
                $context->addViolation(
                    new Violation(
                        'Crotal %s debe entrar en el sistema antes de salir',
                        [$animal->getCrotal()]
                    )
                );
            }
        }

        return $context->getViolations()->toArray();
    }

    /**
     * @param Supression $supressed
     *
     * @return bool
     * @throws \Exception
     */
    private function canGoOutBySupression(Supression $supressed) {
        $now = new \DateTime();
        $finalSupressionDate = $supressed
            ->getSupresionDate()
            ->modify('+ ' . $supressed->getPeriod() . 'day');

        return $now > $finalSupressionDate;
    }

}