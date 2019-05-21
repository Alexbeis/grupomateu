<?php

namespace App\Domain\Entity;

use App\Domain\UseCases\Animal\Birthday\BirthdayMonthCalculator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\AnimalRepository")
 */
class Animal
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="text", length=50)
     */
    private $procedence;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Explotation" , inversedBy="animal")
     * @ORM\JoinColumn(nullable=false)
     */
    private $explotation;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\History", mappedBy="animal")
     */
    private $history;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Race", inversedBy="animal")
     * @JoinColumn(name="race_id", referencedColumnName="id")
     */
    private $race;



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
    public function getProcedence()
    {
        return $this->procedence;
    }

    /**
     * @param mixed $procedence
     */
    public function setProcedence($procedence): void
    {
        $this->procedence = $procedence;
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


}
