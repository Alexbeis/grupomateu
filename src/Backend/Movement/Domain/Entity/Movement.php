<?php

namespace Mateu\Backend\Movement\Domain\Entity;

use Doctrine\ORM\Mapping\JoinColumn;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\User\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Movement\Infraestructure\MovementRepository")
 */

class Movement
{
    const IN = [];
    const OUT = [];

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $from;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $to;

    /**
     * /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal" , inversedBy="movements")
     */
    private $animal;
    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\User\Domain\Entity\User")
     * @JoinColumn(name="created_by_id", referencedColumnName="id")
     */
    private $createdBy;

    public function __construct($from, $to, Animal $animal, User $createdBy)
    {
        $this->from = $from;
        $this->to = $to;
        $this->createdBy = $createdBy;
        $this->animal = $animal;
    }

    public static function create($from, $to, Animal $animal, User $createdBy)
    {
        return new self($from, $to, $animal, $createdBy);
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return Animal|null
     */
    public function getAnimal():?Animal
    {
        return $this->animal;
    }

    /**
     * @param mixed $animal
     *
     * @return Movement
     */
    public function setAnimal($animal): self
    {
        $this->animal = $animal;
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