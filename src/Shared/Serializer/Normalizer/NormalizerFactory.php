<?php

namespace Mateu\Shared\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class NormalizerFactory
{
    public static function create()
    {
        $objectNormalizer = new ObjectNormalizer(null, null, null, null, null, null, []);
        return  [
            new DateTimeNormalizer(),
            $objectNormalizer
        ];
    }

}