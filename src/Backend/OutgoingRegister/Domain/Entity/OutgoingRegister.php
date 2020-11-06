<?php

namespace Mateu\Backend\OutgoingRegister\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\User\Domain\Entity\User;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\OutgoingRegister\Infraestructure\OutgoingRegisterRepository")
 */
class OutgoingRegister
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
    private $destination;

    /**
     * @ORM\Column(type="text", length=50, nullable=true)
     */
    private $outGuide;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $meanWeight;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Explotation\Domain\Entity\Explotation", inversedBy="outgoingRegisters",
     * )
     */
    private $explotation;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Purchaser\Domain\Entity\Purchaser", inversedBy="outgoingRegisters")
     * @JoinColumn(name="purchaser_id", referencedColumnName="id")
     */
    private $purchaser;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Transporter\Domain\Entity\Transporter", inversedBy="outgoingRegisters")
     * @JoinColumn(name="transporter_id", referencedColumnName="id")
     */
    private $transporter;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal",
     *     inversedBy="outgoingRegisters",
     *     cascade={"persist"})
     * @JoinTable(name="outgoing_registers_animals")
     */
    private $animals;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\OutType\Domain\Entity\OutType", inversedBy="outgoingRegisters")
     * @JoinColumn(name="out_type_id", referencedColumnName="id")
     */
    private $outType;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\User\Domain\Entity\User")
     * @JoinColumn(name="created_by_id", referencedColumnName="id")
     */
    private $created_by;

    /**
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $animalsCount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $outDate;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    /**
     * @param string $uuid
     *
     * @return OutgoingRegister
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @param mixed $destination
     *
     * @return OutgoingRegister
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    public function addAnimal(Animal $animal)
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
        }
    }

    /**
     * @param mixed $purchaser
     *
     * @return OutgoingRegister
     */
    public function setPurchaser($purchaser)
    {
        $this->purchaser = $purchaser;
        return $this;
    }

    /**
     * @param ArrayCollection $animals
     *
     * @return OutgoingRegister
     */
    public function setAnimals(ArrayCollection $animals)
    {
        $this->animals = $animals;
        return $this;
    }

    /**
     * @param mixed $outType
     *
     * @return OutgoingRegister
     */
    public function setOutType($outType)
    {
        $this->outType = $outType;
        return $this;
    }

    /**
     * @param mixed $created_by
     *
     * @return OutgoingRegister
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * @param mixed $animalsCount
     *
     * @return OutgoingRegister
     */
    public function setAnimalsCount($animalsCount)
    {
        $this->animalsCount = $animalsCount;
        return $this;
    }

    /**
     * @param DateTime $outDate
     *
     * @return OutgoingRegister
     */
    public function setOutDate($outDate)
    {
        $this->outDate = $outDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return mixed
     */
    public function getPurchaser()
    {
        return $this->purchaser;
    }

    /**
     * @return null|ArrayCollection
     */
    public function getAnimals(): ?PersistentCollection
    {
        return $this->animals;
    }

    /**
     * @return mixed
     */
    public function getOutType()
    {
        return $this->outType;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->created_by;
    }

    /**
     * @return null|integer
     */
    public function getAnimalsCount():? int
    {
        return $this->animalsCount;
    }

    /**
     * @return null | DateTime
     */
    public function getOutDate():? DateTime
    {
        return $this->outDate;
    }

    /**
     * @return mixed
     */
    public function getOutGuide() :?string
    {
        return $this->outGuide;
    }

    /**
     * @param mixed $outGuide
     *
     * @return OutgoingRegister
     */
    public function setOutGuide($outGuide)
    {
        $this->outGuide = $outGuide;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeanWeight()
    {
        return $this->meanWeight;
    }

    /**
     * @param mixed $meanWeight
     *
     * @return OutgoingRegister
     */
    public function setMeanWeight($meanWeight)
    {
        $this->meanWeight = $meanWeight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransporter()
    {
        return $this->transporter;
    }

    /**
     * @param mixed $transporter
     *
     * @return OutgoingRegister
     */
    public function setTransporter($transporter)
    {
        $this->transporter = $transporter;
        return $this;
    }

    /**
     * @return null|Explotation
     */
    public function getExplotation():? Explotation
    {
        return $this->explotation;
    }



}