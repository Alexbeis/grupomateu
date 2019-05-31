<?php

namespace App\Domain\Command\Explotation;

use App\Domain\Entity\User;

class AddExplotationCommand
{
    /**
     * @var String
     */
    private $code;
    /**
     * @var String
     */
    private $name;
    /**
     * @var null
     */
    private $localization;
    /**
     * @var User
     */
    private $createdBy;

    /**
     * AddExplotationCommand constructor.
     * @param String $code
     * @param String $name
     * @param null $localization
     * @param User $createdBy
     */
    public function __construct(String $code, String $name, $localization, User $createdBy)
    {
        $this->code = $code;
        $this->name = $name;
        $this->localization = $localization;
        $this->createdBy = $createdBy;
    }

    /**
     * @return String
     */
    public function getCode(): String
    {
        return $this->code;
    }

    /**
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getLocalization(): ?String
    {
        return $this->localization;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

}