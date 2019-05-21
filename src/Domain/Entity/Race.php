<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\RaceRepository")
 */
class Race
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15, nullable=false)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Animal", mappedBy="race", fetch="LAZY")
     * @JoinColumn(name="animal_id", referencedColumnName="id")
     */
    private $animal;

    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
        $this->animal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCode():string
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
    public function getName():string
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