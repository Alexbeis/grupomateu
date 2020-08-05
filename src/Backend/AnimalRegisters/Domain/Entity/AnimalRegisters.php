<?php

namespace Mateu\Backend\AnimalRegisters\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\AnimalRegisters\Infraestructure\DoctrineAnimalRegistersRepository")
 * @Table(indexes={
 *     @Index(name="crotalNum_idx", columns={"crotal"})}
 * )
 */
class AnimalRegisters
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $crotal;

    /**
     * @ORM\Column(type="string", nullable=false, length=40)
     */
    private $incomingRegisterUuid;

    /**
     * @ORM\Column(type="string", nullable=true, length=40)
     */
    private $outgoingRegisterUuid;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCrotal()
    {
        return $this->crotal;
    }

    /**
     * @param mixed $crotalNum
     *
     * @return AnimalRegisters
     */
    public function setCrotal($crotalNum): self
    {
        $this->crotal = $crotalNum;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIncomingRegisterUuid()
    {
        return $this->incomingRegisterUuid;
    }

    /**
     * @param $incomingRegisterUuid
     *
     * @return AnimalRegisters
     */
    public function setIncomingRegisterUuid($incomingRegisterUuid): self
    {
        $this->incomingRegisterUuid = $incomingRegisterUuid;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutgoingRegisterUuid()
    {
        return $this->outgoingRegisterUuid;
    }

    /**
     * @param $outgoingRegisterUuid
     *
     * @return AnimalRegisters
     */
    public function setOutgoingRegisterUuid($outgoingRegisterUuid): self
    {
        $this->outgoingRegisterUuid = $outgoingRegisterUuid;

        return $this;
    }
}