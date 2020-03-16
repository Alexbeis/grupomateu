<?php

namespace Mateu\Backend\Group\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\PersistentCollection;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;

/**
 * Class Group
 * @ORM\Entity(repositoryClass="Mateu\Backend\Group\Infraestructure\GroupRepository")
 * @Table("`group`")
 */
class Group
{
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
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Explotation\Domain\Entity\Explotation", mappedBy="group")
     */
    private $explotations;

    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
        $this->explotations = new ArrayCollection();

    }

    public static function create($code, $name)
    {
        return new self($code, $name);
    }

    /**
     * @return string|null
     */
    public function getCode():?string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName():string
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
     * @return ArrayCollection|null
     */
    public function getExplotations(): ?PersistentCollection
    {
        return $this->explotations;
    }

    /**
     * @param Explotation $explotation
     */
    public function addExplotation(Explotation $explotation)
    {
        if(!$this->explotations->contains($explotation)) {
            $this->explotations->add($explotation);
        }
    }
}

