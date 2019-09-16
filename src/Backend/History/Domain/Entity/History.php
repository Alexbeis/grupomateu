<?php

namespace Mateu\Backend\History\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\History\Infraestructure\HistoryRepository")
 */

class History
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */

    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal" , inversedBy="history")
     */
    private $animal;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\User\Domain\Entity\User")
     * @JoinColumn(name="created_by_id", referencedColumnName="id")
     */
    private $created_by;

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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     *
     * @return History
     */
    public function setComment($comment): self
    {
        $this->comment = $comment;
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
     *
     * @return History
     */
    public function setAnimal($animal): self
    {
        $this->animal = $animal;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getComment();
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     *
     * @return History
     */
    public function setCreatedBy($created_by): self
    {
        $this->created_by = $created_by;
        return $this;
    }

}