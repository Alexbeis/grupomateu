<?php

namespace Mateu\Backend\Animal\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Animal\Infraestructure\SupressionRepository")
 */
class Supression
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $supresionDate;

    /**
     * @ORM\Column(type="string", nullable=false, length=50)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $period;

    public function __construct(DateTime $supresionDate, string $product, int $period)
    {
        $this->supresionDate = $supresionDate;
        $this->period = $period;
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getSupresionDate(): DateTime
    {
        return $this->supresionDate;
    }

    /**
     * @return int
     */
    public function getPeriod():int
    {
        return $this->period;
    }

    /**
     * @return mixed
     */
    public function getProduct():string
    {
        return $this->product;
    }
}