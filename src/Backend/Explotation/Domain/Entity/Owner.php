<?php

namespace Mateu\Backend\Explotation\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Explotation\Infraestructure\OwnerRepository")
 */
class Owner
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
     * @ORM\Column(type="string" , length=50)
     */
    private $nif;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Explotation\Domain\Entity\Explotation", mappedBy="owner")
     */
    private $explotations;

    public function __construct($code, $name, $nif)
    {
        $this->explotations = new ArrayCollection();
        $this->code = $code;
        $this->name = $name;
        $this->nif = $nif;
    }

    public static function create($code, $name, $nif)
    {
        return new self($code, $name, $nif);
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     *
     * @return Owner
     */
    public function setCode($code)
    {
        $this->code = $code;
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
     *
     * @return Owner
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNif():?string
    {
        return $this->nif;
    }

    /**
     * @param mixed $nif
     *
     * @return Owner
     */
    public function setNif($nif)
    {
        $this->nif = $nif;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExplotations()
    {
        return $this->explotations;
    }


    public function addExplotation(Explotation $explotation)
    {
        if (!$this->explotations->contains($explotation)) {
            $this->explotations->add($explotation);
        }
    }

}