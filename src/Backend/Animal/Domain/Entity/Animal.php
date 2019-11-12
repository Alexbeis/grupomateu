<?php

namespace Mateu\Backend\Animal\Domain\Entity;

use DateTime;
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
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $is_ill;

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
     * @ORM\OneToMany(targetEntity="Mateu\Backend\Movement\Domain\Entity\Movement", mappedBy="animal", fetch="EXTRA_LAZY")
     */
    private $movements;

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
        $this->history = new ArrayCollection();
        $this->movements = new ArrayCollection();
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
     *
     * @return Animal
     */
    public function setCrotal($crotal): self
    {
        $this->crotal = $crotal;

        return $this;
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
     *
     * @return Animal
     */
    public function setInternalNum($internal_num): self
    {
        $this->internal_num = $internal_num;

        return $this;
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
     *
     * @return Animal
     */
    public function setWeightIn($weight_in): self
    {
        $this->weight_in = $weight_in;

        return $this;
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
     *
     * @return Animal
     */
    public function setWeightOut($weight_out): self
    {
        $this->weight_out = $weight_out;

        return $this;
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
     *
     * @return Animal
     */
    public function setExplotation($explotation): self
    {
        $this->explotation = $explotation;

        return $this;
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
     *
     * @return Animal
     */
    public function setBirthDate($birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
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
     *
     * @return Animal
     */
    public function setHistory($history): self
    {
        $this->history = $history;
        return $this;
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
     *
     * @return Animal
     */
    public function setCrotalMother($crotal_mother):self
    {
        $this->crotal_mother = $crotal_mother;

        return $this;
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
     *
     * @return Animal
     */
    public function setGenre($genre):self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getMonthsOld()
    {
        $calculator = new BirthdayMonthCalculator();

        return $calculator->getMonthAge($this->birth_date, new DateTime());
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
     *
     * @return Animal
     */
    public function setRace($race):self
    {
        $this->race = $race;

        return $this;
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

    /**
     * @return mixed
     */
    public function getIsIll()
    {
        return $this->is_ill;
    }

    /**
     * @param mixed $is_ill
     *
     * @return Animal
     */
    public function setIsIll($is_ill): self
    {
        $this->is_ill = $is_ill;
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getMovements()
    {
        return $this->movements;
    }

    /**
     * @param ArrayCollection $movements
     *
     * @return ArrayCollection|null
     */
    public function setMovements($movements): ?ArrayCollection
    {
        $this->movements = $movements;
    }
}
