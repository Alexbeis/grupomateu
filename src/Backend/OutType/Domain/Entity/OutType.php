<?php

namespace Mateu\Backend\OutType\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class OutType
 * @ORM\Entity(repositoryClass="Mateu\Backend\OutType\Infraestructure\OutTypeRepository")
 */
class OutType
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=10, unique=true, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string" , length=50)
     */
    private $name;

    public function __construct($uuid, $code, $name)
    {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->name = $name;
    }

    public static function create($uuid, $code, $name)
    {
        return new self($uuid, $code, $name);
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getName()
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
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
