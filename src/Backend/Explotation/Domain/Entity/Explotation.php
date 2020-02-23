<?php

namespace Mateu\Backend\Explotation\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Explotation\Infraestructure\ExplotationRepository")
 */
class Explotation
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string" , length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $localization;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal" , mappedBy="explotation")
     */
    private $animal;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister", mappedBy="explotation")
     */
    private $incomingRegisters;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\User\Domain\Entity\User")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Group\Domain\Entity\Group", inversedBy="explotations")
     */
    private $group;


    public function __construct()
    {
        $this->animal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return Explotation
     */
    public function setCode($code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocalization()
    {
        return $this->localization;
    }

    /**
     * @param mixed $localization
     * @return Explotation
     */
    public function setLocalization($localization): self
    {
        $this->localization = $localization;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Explotation
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * @param mixed $animal
     * @return Explotation
     */
    public function setAnimal($animal): self
    {
        $this->animal = $animal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     * @return Explotation
     */
    public function setCreatedBy($createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }


    public function __toString()
    {
        return (string) $this->getCode();
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     *
     * @return Explotation
     */
    public function setGroup($group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get Ill Animals from current Explotation
     * @return Collection|null
     */
    public function getIllAnimals():?Collection
    {
        //TODO: Get criteria from repository
        $criteria = Criteria::create()
            ->andWhere(
                Criteria::expr()->eq('is_ill', true)
            )
            ->orderBy(['updatedAt' => 'DESC']);

        return $this->animal->matching($criteria);
    }
}
