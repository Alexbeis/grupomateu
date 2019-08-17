<?php

namespace Mateu\Backend\Explotation\Application\Save;

class SaveExplotationCommand
{
    private $id;
    private $name;
    private $code;
    private $localization;
    private $group;

    public function __construct($id, $name, $code, $localization, $group)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->localization = $localization;
        $this->group = $group;
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
    public function getName()
    {
        return $this->name;
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
    public function getLocalization()
    {
        return $this->localization;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

}