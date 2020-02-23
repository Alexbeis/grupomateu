<?php

namespace Mateu\Backend\Purchaser\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Purchaser\Infraestructure\PurchaserRepository")
 */
class Purchaser
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $contactName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mobilePhone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\OutgoingRegister\Domain\Entity\OutgoingRegister", mappedBy="purchaser")
     */
    private $outgoingRegisters;

    public function __construct()
    {
        $this->outgoingRegisters = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     *
     * @return Purchaser
     */
    public function setCompanyName($companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @param mixed $contactName
     *
     * @return Purchaser
     */
    public function setContactName($contactName): self
    {
        $this->contactName = $contactName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return Purchaser
     */
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     *
     * @return Purchaser
     */
    public function setAddress($address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     *
     * @return Purchaser
     */
    public function setCity($city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     *
     * @return Purchaser
     */
    public function setRegion($region): self
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     *
     * @return Purchaser
     */
    public function setPostalCode($postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     *
     * @return Purchaser
     */
    public function setCountry($country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     *
     * @return Purchaser
     */
    public function setPhone($phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @param mixed $mobilePhone
     *
     * @return Purchaser
     */
    public function setMobilePhone($mobilePhone): self
    {
        $this->mobilePhone = $mobilePhone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     *
     * @return Purchaser
     */
    public function setFax($fax): self
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     *
     * @return Purchaser
     */
    public function setWebsite($website): self
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutgoingRegisters()
    {
        return $this->outgoingRegisters;
    }

    /**
     * @param mixed $outgoingRegisters
     *
     * @return Purchaser
     */
    public function setOutgoingRegisters($outgoingRegisters): self
    {
        $this->outgoingRegisters = $outgoingRegisters;

        return $this;
    }

}
