<?php

namespace Mateu\Backend\Race\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Race\Infraestructure\RaceRepository")
 */
class Race
{
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
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal", mappedBy="race", fetch="LAZY")
     * @JoinColumn(name="animal_id", referencedColumnName="id")
     */
    private $animal;

    public function __construct($uuid, $code, $name)
    {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->name = $name;
        $this->animal = new ArrayCollection();
    }

    public static function create($uuid, $code, $name)
    {
        return new self($uuid, $code, $name);
    }

    public function getId(): ?int
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
    public function getCode():?string
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getName():?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnimal()
    {
        return $this->animal;
    }
}