<?php

namespace Mateu\Backend\IncomingRegister\Domain;

class TimeIntervalExtractor
{
    public static function fromString(string $stringDate)
    {
        return [
            substr($stringDate,0, 2),
            substr($stringDate,2, 2),
            substr($stringDate,4, 4)
        ];
    }
}