<?php

namespace Mateu\Backend\Explotation\Application\Create;


use Mateu\Backend\User\Domain\Entity\User;

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
     * @var int
     */
    private $group_id;

    /**
     * AddExplotationCommand constructor.
     *
     * @param String $code
     * @param String $name
     * @param int $group_id
     * @param null $localization
     * @param User $createdBy
     */
    public function __construct(String $code, String $name, int $group_id, $localization, User $createdBy)
    {
        $this->code = $code;
        $this->name = $name;
        $this->localization = $localization;
        $this->createdBy = $createdBy;
        $this->group_id = $group_id;
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

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->group_id;
    }

}