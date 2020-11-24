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
    private $initial;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $last;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

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

    public function __construct($from, $to, Animal $animal, User $createdBy, string $type)
    {
        $this->initial = $from;
        $this->last = $to;
        $this->createdBy = $createdBy;
        $this->animal = $animal;
        $this->type = $type;
    }

    public static function createStandard($from, $to, Animal $animal, User $createdBy)
    {
        return new self($from, $to, $animal, $createdBy, 'standard');
    }

    public static function fromIncomingRegister($from, $to, Animal $animal, User $createdBy)
    {
        return new self($from, $to, $animal, $createdBy, 'in_register');
    }

    /**
     * @return mixed
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * @return mixed
     */
    public function getLast()
    {
        return $this->last;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}