<?php

namespace Mateu\Backend\IncomingRegister\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\InType\Domain\Entity\InType;
use Mateu\Backend\Supplier\Domain\Entity\Supplier;
use Mateu\Backend\User\Domain\Entity\User;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\IncomingRegister\Infraestructure\IncomingRegisterRepository")
 *  @Table(indexes={
 *     @Index(name="inc_register_uuid_idx", columns={"uuid"}),
 *     }
 * )
 */
class IncomingRegister
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40, nullable=false, unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $procedence;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $guideNum;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $guideDate;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $originExplotation;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $totalAnimalsFromGuide;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $animalsCount;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Supplier\Domain\Entity\Supplier", inversedBy="incomingRegisters")
     * @JoinColumn(name="supplier_id", referencedColumnName="id")
     */
    private $supplier;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal",
     *     inversedBy="incomingRegisters",
     *     cascade={"persist"})
     * @JoinTable(name="incoming_registers_animals")
     */
    private $animals;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Explotation\Domain\Entity\Explotation", inversedBy="incomingRegisters")
     */
    private $explotation;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\InType\Domain\Entity\InType", inversedBy="incomingRegisters")
     * @JoinColumn(name="in_type_id", referencedColumnName="id")
     */
    private $inType;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\User\Domain\Entity\User")
     * @JoinColumn(name="created_by_id", referencedColumnName="id")
     */
    private $created_by;


    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public static function fromPhaseOne(
        string $uuid,
        InType $inType,
        Explotation $explotation,
        string $procedence,
        Supplier $supplier,
        $guideNum,
        $guideAnimals,
        $guideDate,
        $origin,
        User $user
    ) {
        return (new self())
            ->setUuid($uuid)
            ->setExplotation($explotation)
            ->setSupplier($supplier)
            ->setInType($inType)
            ->setProcedence($procedence)
            ->setGuideNum($guideNum)
            ->setTotalAnimalsFromGuide($guideAnimals)
            ->setGuideDate($guideDate)
            ->setOriginExplotation($origin)
            ->setCreatedBy($user)
            ->setAnimalsCount(0);
    }

    /**
     * @return mixed
     */
    public function getProcedence() :string
    {
        return $this->procedence;
    }

    /**
     * @param mixed $procedence
     *
     * @return IncomingRegister
     */
    public function setProcedence($procedence): self
    {
        $this->procedence = $procedence;

        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getAnimals() :?PersistentCollection
    {
        return $this->animals;
    }

    /**
     * @param mixed
     *
     * @return IncomingRegister
     */
    public function setAnimals($animals): self
    {
        $this->animals = $animals;

        return $this;
    }

    /**
     * @param Animal $animal
     */
    public function addAnimal(Animal $animal) :void
    {
        $this->animals->add($animal);
        $animal->addIncomingRegister($this);
    }

    /**
     * @param Animal $animal
     */
    public function removeAnimal(Animal $animal)
    {
        if ($this->animals->contains($animal)) {
            $this->animals->removeElement($animal);
        }
    }

    /**
     * @param mixed $inType
     *
     * @return IncomingRegister
     */
    public function setInType($inType) :self
    {
        $this->inType = $inType;
        return $this;
}

    /**
     * @return mixed
     */
    public function getInType()
    {
        return $this->inType;
    }

    /**
     * @param mixed $supplier
     *
     * @return IncomingRegister
     */
    public function setSupplier($supplier): self
    {
        $this->supplier = $supplier;
        return $this;
}

    /**
     * @return mixed
     */
    public function getSupplier() :?Supplier
    {
        return $this->supplier;
    }

    /**
     * @return User
     */
    public function getCreatedBy():User
    {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     *
     * @return IncomingRegister
     */
    public function setCreatedBy($created_by): self
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalAnimalsFromGuide():int
    {
        return $this->totalAnimalsFromGuide;
    }

    /**
     * @param int $totalAnimalsFromGuide
     *
     * @return IncomingRegister
     */
    public function setTotalAnimalsFromGuide(int $totalAnimalsFromGuide):self
    {
        $this->totalAnimalsFromGuide = $totalAnimalsFromGuide;
        return $this;
    }


    /**
     * @return integer
     */
    public function getAnimalsCount()
    {
        return $this->animalsCount;
    }

    /**
     * @param mixed $animalsCount
     *
     * @return IncomingRegister
     */
    public function setAnimalsCount($animalsCount): self
    {
        $this->animalsCount = $animalsCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     *
     * @return IncomingRegister
     */
    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @param mixed $explotation
     *
     * @return IncomingRegister
     */
    public function setExplotation($explotation)
    {
        $this->explotation = $explotation;
        return $this;
}

    /**
     * @return Explotation
     */
    public function getExplotation()
    {
        return $this->explotation;
    }

    /**
     * @return mixed
     */
    public function getGuideNum()
    {
        return $this->guideNum;
    }

    /**
     * @param $guideNum
     *
     * @return IncomingRegister
     */
    public function setGuideNum($guideNum): self
    {
        $this->guideNum = $guideNum;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuideDate()
    {
        return $this->guideDate;
    }

    /**
     * @param mixed $guideDate
     *
     * @return IncomingRegister
     */
    public function setGuideDate($guideDate): self
    {
        $this->guideDate = $guideDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginExplotation()
    {
        return $this->originExplotation;
    }

    /**
     * @param mixed $originExplotation
     *
     * @return IncomingRegister
     */
    public function setOriginExplotation($originExplotation): self
    {
        $this->originExplotation = $originExplotation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
