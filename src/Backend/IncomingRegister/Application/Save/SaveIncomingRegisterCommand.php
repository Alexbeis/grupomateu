<?php

namespace Mateu\Backend\IncomingRegister\Application\Save;

class SaveIncomingRegisterCommand
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $explotationId;
    /**
     * @var int
     */
    private $procedenceCode;
    /**
     * @var int
     */
    private $inTypeId;
    /**
     * @var int
     */
    private $supplierId;
    private $guideNum;
    private $guideAnimals;
    private $guideDate;
    private $origin;

    public function __construct(
        int $id, int $explotationId,
        string $procedenceCode,
        int $inTypeId,
        int $supplierId,
        $guideNum,
        $guideAnimals,
        $guideDate,
        $origin
    ) {
        $this->id = $id;
        $this->explotationId = $explotationId;
        $this->procedenceCode = $procedenceCode;
        $this->inTypeId = $inTypeId;
        $this->supplierId = $supplierId;
        $this->guideNum = $guideNum;
        $this->guideAnimals = $guideAnimals;
        $this->guideDate = $guideDate;
        $this->origin = $origin;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getExplotationId(): int
    {
        return $this->explotationId;
    }

    /**
     * @return int
     */
    public function getProcedenceCode(): string
    {
        return $this->procedenceCode;
    }

    /**
     * @return int
     */
    public function getInTypeId(): int
    {
        return $this->inTypeId;
    }

    /**
     * @return int
     */
    public function getSupplierId(): int
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
    public function getGuideAnimals()
    {
        return $this->guideAnimals;
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
}