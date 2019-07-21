<?php

namespace Mateu\Backend\Explotation\Application\Save;

class SaveExplotationCommand
{
    private $id;
    private $name;
    private $code;
    private $localization;

    public function __construct($id, $name, $code, $localization)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->localization = $localization;
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

}