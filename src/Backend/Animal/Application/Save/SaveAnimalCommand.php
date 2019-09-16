<?php

namespace Mateu\Backend\Animal\Application\Save;

class SaveAnimalCommand
{
    private $id;
    private $internalNum;
    private $crotal;
    private $crotalMother;
    private $weightIn;
    private $weightOut;
    private $genre;
    private $raceId;
    private $birthdate;

    public function __construct($id, $internalNum, $crotal, $crotalMother, $weightIn, $weightOut, $birthdate, $genre, $raceId)
    {
        $this->id = $id;
        $this->internalNum = $internalNum;
        $this->crotal = $crotal;
        $this->crotalMother = $crotalMother;
        $this->weightIn = $weightIn;
        $this->weightOut = $weightOut;
        $this->birthdate = $birthdate;
        $this->genre = $genre;
        $this->raceId = $raceId;
    }

    /**
     * @return mixed
     */
    public function getInternalNum()
    {
        return $this->internalNum;
    }

    /**
     * @return mixed
     */
    public function getCrotal()
    {
        return $this->crotal;
    }

    /**
     * @return mixed
     */
    public function getCrotalMother()
    {
        return $this->crotalMother;
    }

    /**
     * @return mixed
     */
    public function getWeightIn()
    {
        return $this->weightIn;
    }

    /**
     * @return mixed
     */
    public function getWeightOut()
    {
        return $this->weightOut;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getRaceId()
    {
        return $this->raceId;
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
    public function getBirthdate()
    {
        return $this->birthdate;
    }
}
