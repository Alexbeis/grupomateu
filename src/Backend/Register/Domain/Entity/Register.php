<?php

namespace Mateu\Backend\Register\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Supplier\Domain\Entity\Supplier;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Register\Infraestructure\RegisterRepository")
 */
class Register
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;
    /**
     * @ORM\Column(type="text", length=50, nullable=true)
     */
    private $procedence;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Supplier\Domain\Entity\Supplier", inversedBy="registers")
     * @JoinColumn(name="supplier_id", referencedColumnName="id")
     */
    private $supplier;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal", mappedBy="register", cascade={"persist"})
     */
    private $animals;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\InType\Domain\Entity\InType", inversedBy="register")
     * @JoinColumn(name="in_type_id", referencedColumnName="id")
     */
    private $inType;

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
     * @return Register
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
     * @return Register
     */
    public function setAnimals($animals): self
    {
        $this->animals = $animals;

        return $this;
    }

    public function addAnimal(Animal $animal) :void
    {
        if (!$this->animals->contains($animal)) {
            $animal->setRegister($this);
            $this->animals->add($animal);
        }
    }

    /**
     * @param mixed $inType
     *
     * @return Register
     */
    public function setInType($inType)
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
     * @return Register
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
}