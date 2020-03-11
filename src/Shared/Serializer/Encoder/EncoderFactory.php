<?php

namespace Mateu\Shared\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\CsvEncoder;

class EncoderFactory
{
    public static function create()
    {
        return [new CsvEncoder()];
    }

}