<?php

namespace Mateu\Backend\OutgoingRegister\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\OutgoingRegister\Infraestructure\OutgoingRegisterRepository")
 */
class OutgoingRegister
{
    use TimestampableEntity;

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
     * @ORM\Column(type="text", length=50, nullable=true)
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Purchaser\Domain\Entity\Purchaser", inversedBy="outgoingRegisters")
     * @JoinColumn(name="purchaser_id", referencedColumnName="id")
     */
    private $purchaser;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal", mappedBy="outgoingRegister", cascade={"persist"})
     */
    private $animals;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\OutType\Domain\Entity\OutType", inversedBy="outgoingRegisters")
     * @JoinColumn(name="out_type_id", referencedColumnName="id")
     */
    private $outType;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\User\Domain\Entity\User")
     * @JoinColumn(name="created_by_id", referencedColumnName="id")
     */
    private $created_by;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $animalsCount;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }


}