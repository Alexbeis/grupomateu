<?php

namespace Mateu\Backend\IncomingRegister\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Supplier\Domain\Entity\Supplier;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\IncomingRegister\Infraestructure\IncomingRegisterRepository")
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
     * @ORM\Column(type="string", length=40, nullable=false)
     */
    private $uuid;
    /**
     * @ORM\Column(type="text", length=50, nullable=true)
     */
    private $procedence;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Supplier\Domain\Entity\Supplier", inversedBy="incomingRegisters")
     * @JoinColumn(name="supplier_id", referencedColumnName="id")
     */
    private $supplier;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal", mappedBy="incomingRegister", cascade={"persist"})
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

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $animalsCount;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
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

    public function addAnimal(Animal $animal) :void
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setIncomingRegister($this);
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
     * @return mixed
     */
    public function getCreatedBy()
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
}
