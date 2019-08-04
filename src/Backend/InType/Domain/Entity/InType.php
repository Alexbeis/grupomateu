<?php

namespace Mateu\Backend\InType\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class InType
 * @ORM\Entity(repositoryClass="Mateu\Backend\InType\Infraestructure\InTypeRepository")
 */
class InType
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string" , length=50)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal", mappedBy="inType")
     */
    private $animal;

    public function __construct($uuid, $code, $name)
    {
        $this->code = $code;
        $this->name = $name;
        $this->uuid = $uuid;
        $this->animal = new ArrayCollection();
    }

    public static function create($uuid, $code, $name)
    {
        return new self($uuid, $code, $name);
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnimal():?ArrayCollection
    {
        return $this->animal;
    }
}