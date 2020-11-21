<?php

namespace Mateu\Backend\IncomingRegister\Application\Create;

class CreateIncomingRegisterCommand
{
    private $uuid;
    private $inTypeId;
    private $procedende;
    private $explotationId;
    private $supplierId;
    private $guideNum;
    private $guideDate;
    private $origin;
    private $totalGuideAnimals;

    public function __construct(
        $uuid,
        $inTypeId,
        $procedende,
        $explotationId,
        $supplierId,
        $guideNum,
        $guideDate,
        $origin,
        $totalGuideAnimals
    ) {

        $this->uuid = $uuid;
        $this->inTypeId = $inTypeId;
        $this->procedende = $procedende;
        $this->explotationId = $explotationId;
        $this->supplierId = $supplierId;
        $this->guideNum = $guideNum;
        $this->guideDate = $guideDate;
        $this->origin = $origin;
        $this->totalGuideAnimals = $totalGuideAnimals;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getInTypeId()
    {
        return $this->inTypeId;
    }

    /**
     * @return mixed
     */
    public function getProcedende()
    {
        return $this->procedende;
    }

    /**
     * @return mixed
     */
    public function getExplotationId()
    {
        return $this->explotationId;
    }

    /**
     * @return mixed
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * @return mixed
     */
    public function getGuideNum()
    {
        return $this->guideNum;
    }

    /**
     * @return mixed
     */
    public function getGuideDate()
    {
        return $this->guideDate;
    }

    /**
     * @return mixed
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @return mixed
     */
    public function getTotalGuideAnimals()
    {
        return $this->totalGuideAnimals;
    }
}