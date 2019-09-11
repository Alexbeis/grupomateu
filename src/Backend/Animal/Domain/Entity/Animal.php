<?php

namespace Mateu\Backend\Animal\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\Table;
use Mateu\Backend\Animal\Domain\BirthdayMonthCalculator;
use Mateu\Backend\Annex\Domain\Entity\Annex;
use Mateu\Backend\History\Domain\Entity\History;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Animal\Infraestructure\AnimalRepository")
 * @Table(indexes={
 *     @Index(name="crotal_idx", columns={"crotal"}),
 *     @Index(name="internal_idx", columns={"internal_num"})}
 *     )
 */
class Animal
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $internal_num;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $crotal;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $crotal_mother;

    /**
     * @ORM\Column(type="integer" , nullable=true)
     */
    private $weight_in;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight_out;

    /**
     * @ORM\Column(type="date")
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $genre;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Explotation\Domain\Entity\Explotation" , inversedBy="animal")
     * @ORM\JoinColumn(nullable=false)
     */
    private $explotation;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\History\Domain\Entity\History", mappedBy="animal")
     */
    private $history;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Race\Domain\Entity\Race", inversedBy="animal")
     * @JoinColumn(name="race_id", referencedColumnName="id")
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity="Mateu\Backend\Register\Domain\Entity\Register", inversedBy="animals")
     * @JoinColumn(name="register_id", referencedColumnName="id")
     */
    private $register;

    /**
     * @ORM\OneToOne(targetEntity="Mateu\Backend\Annex\Domain\Entity\Annex", mappedBy="animal")
     */
    private $annex;


    public function __construct()
    {
        $this->explotation = new ArrayCollection();
        $this->history = new ArrayCollection();
    }

    public function getId(): ?int
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
     * @param mixed $crotal
     */
    public function setCrotal($crotal): void
    {
        $this->crotal = $crotal;
    }

    /**
     * @return mixed
     */
    public function getInternalNum()
    {
        return $this->internal_num;
    }

    /**
     * @param mixed $internal_num
     */
    public function setInternalNum($internal_num): void
    {
        $this->internal_num = $internal_num;
    }

    /**
     * @return mixed
     */
    public function getWeightIn()
    {
        return $this->weight_in;
    }

    /**
     * @param mixed $weight_in
     */
    public function setWeightIn($weight_in): void
    {
        $this->weight_in = $weight_in;
    }

    /**
     * @return mixed
     */
    public function getWeightOut()
    {
        return $this->weight_out;
    }

    /**
     * @param mixed $weight_out
     */
    public function setWeightOut($weight_out): void
    {
        $this->weight_out = $weight_out;
    }

    /**
     * @return mixed
     */
    public function getExplotation()
    {
        return $this->explotation;
    }

    /**
     * @param mixed $explotation
     */
    public function setExplotation($explotation): void
    {
        $this->explotation = $explotation;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param mixed $birth_date
     */
    public function setBirthDate($birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @return ArrayCollection|History[]
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param mixed $history
     */
    public function setHistory($history): void
    {
        $this->history = $history;
    }
    public function __toString()
    {
        return (string) $this->getInternalNum();
    }


    /**
     * @return null|string
     */
    public function getCrotalMother(): ?string
    {
        return $this->crotal_mother;
    }

    /**
     * @param mixed $crotal_mother
     */
    public function setCrotalMother($crotal_mother)
    {
        $this->crotal_mother = $crotal_mother;
    }

    /**
     * @return mixed
     */
    public function getGenre(): ?string
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getMonthsOld()
    {
        $calculator = new BirthdayMonthCalculator($this->birth_date->format('Y-m-d'));

        return $calculator->getMonthAge('NOW');
    }

    /**
     * @return mixed
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param mixed $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    /**
     * @param mixed $register
     *
     * @return Animal
     */
    public function setRegister($register)
    {
        $this->register = $register;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     * @return mixed
     */
    public function getAnnex():?Annex
    {
        return $this->annex;
    }

    /**
     * @param mixed $annex
     *
     * @return Animal
     */
    public function setAnnex($annex): self
    {
        $this->annex = $annex;
        return $this;
    }


}
