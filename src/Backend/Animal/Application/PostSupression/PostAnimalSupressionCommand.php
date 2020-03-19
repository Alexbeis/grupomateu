<?php

namespace Mateu\Backend\Animal\Application\PostSupression;

class PostAnimalSupressionCommand
{
    private $animalId;
    private $supressionDate;
    private $days;
    private $product;

    public function __construct(int $animalId, string $days, string $product, string $supressionDate)
    {
        $this->animalId = $animalId;
        $this->days = $days;
        $this->product = $product;
        $this->supressionDate = $supressionDate;
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getAnimalId(): int
    {
        return $this->animalId;
    }

    /**
     * @return string
     */
    public function getSupressionDate(): string
    {
        return $this->supressionDate;
    }

    /**
     * @return string
     */
    public function getDays(): string
    {
        return $this->days;
    }
}