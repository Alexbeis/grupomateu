<?php

namespace Mateu\Backend\Annex\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Annex\Infraestructure\AnnexRepository")
 *
 */
class Annex
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    /**
     * @OneToOne(targetEntity="Mateu\Backend\Animal\Domain\Entity\Animal", inversedBy="annex")
     */
    private $animal;

    public function __construct($animal)
    {
        $this->animal = $animal;
    }

    public static function fromAnimal($animal)
    {
        return new self($animal);
    }
}