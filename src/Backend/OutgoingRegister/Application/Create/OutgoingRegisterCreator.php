<?php
declare( strict_types = 1 );

namespace Mateu\Backend\OutgoingRegister\Application\Create;

use Doctrine\ORM\EntityManagerInterface;

use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Mateu\Backend\OutgoingRegister\Application\Validation\OutgoingAnimalValidation;
use Mateu\Backend\OutgoingRegister\Domain\Entity\OutgoingRegister;
use Mateu\Backend\OutgoingRegister\Infraestructure\OutgoingRegisterRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Workflow\Registry;

final class OutgoingRegisterCreator
{
    /**
     * @var AnnexRepositoryInterface
     */
    private $annexRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var OutgoingRegisterRepository
     */
    private $outgoingRegisterRepository;
    /**
     * @var OutgoingAnimalValidation
     */
    private $animalValidation;
    /**
     * @var Security
     */
    private $security;
    /**
     * @var Registry
     */
    private $workflow;

    public function __construct(
        AnnexRepositoryInterface $annexRepository,
        EntityManagerInterface $entityManager,
        OutgoingRegisterRepository $outgoingRegisterRepository,
        OutgoingAnimalValidation $animalValidation,
        Security $security,
        Registry $workflow
    ) {
        $this->annexRepository = $annexRepository;
        $this->entityManager = $entityManager;
        $this->outgoingRegisterRepository = $outgoingRegisterRepository;
        $this->animalValidation = $animalValidation;
        $this->security = $security;
        $this->workflow = $workflow;
    }

    public function create($expCode, $uuid)
    {
        $result = $this->animalValidation->validate($expCode);

        if (!empty($result)) {
            throw new \Exception('Registro de Salida no Permitido');
        }

        $outRegister = new OutgoingRegister();
        $outRegister
            ->setUuid($uuid)
            ->setAnimalsCount(0)
            ->setCreatedBy($this->security->getUser());

        $annexedAnimals = $this->annexRepository->getAnnexedAnimalsByExplotationCode($expCode);

        foreach ($annexedAnimals as $annexed) {
            /**
             * @var Animal $animal
             */
            $animal = $annexed->getAnimal();

            $animalStateMachine = $this->workflow->get($animal);
            $animalStateMachine->apply($animal, 'to_outgoing');

            $outRegister->addAnimal($animal);

            $animal->setExplotation(null);
            $animal->setAnnex(null);
        }

        $outRegister->setAnimalsCount(count($annexedAnimals));
        $this->entityManager->persist($outRegister);
        $this->entityManager->flush();

        // remove or unlink annexed animals from its explotation code

        // Send events (update censo, explotation(remove) and outgoing animal-counter(add))
    }
}