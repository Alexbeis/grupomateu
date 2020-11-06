<?php

namespace Mateu\Backend\Transporter\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="Mateu\Backend\Transporter\Infraestructure\DoctrineTransporterRepository")
 */
class Transporter
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned" = true})
     */
    private $id;

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
     * @ORM\Column(type="string", length=50, nullable=true)
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
     * @ORM\Column(type="string", length=50, nullable=true)
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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $mobilePhone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity="Mateu\Backend\OutgoingRegister\Domain\Entity\OutgoingRegister", mappedBy="transporter")
     */
    private $outgoingRegisters;

    public function __construct()
    {
        $this->outgoingRegisters = new ArrayCollection();
    }

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
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @return mixed
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @return mixed
     */
    public function getOutgoingRegisters()
    {
        return $this->outgoingRegisters;
    }

    /**
     * @param mixed $companyName
     *
     * @return Transporter
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @param mixed $contactName
     *
     * @return Transporter
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
        return $this;
    }

    /**
     * @param mixed $email
     *
     * @return Transporter
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param mixed $address
     *
     * @return Transporter
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param mixed $city
     *
     * @return Transporter
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @param mixed $region
     *
     * @return Transporter
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @param mixed $postalCode
     *
     * @return Transporter
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @param mixed $country
     *
     * @return Transporter
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @param mixed $phone
     *
     * @return Transporter
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param mixed $mobilePhone
     *
     * @return Transporter
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
        return $this;
    }

    /**
     * @param mixed $fax
     *
     * @return Transporter
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @param mixed $website
     *
     * @return Transporter
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @param mixed $outgoingRegisters
     *
     * @return Transporter
     */
    public function setOutgoingRegisters($outgoingRegisters)
    {
        $this->outgoingRegisters = $outgoingRegisters;
        return $this;
    }
}