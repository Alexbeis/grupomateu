<?php

namespace Mateu\Shared\Serializer;

use Mateu\Shared\Serializer\Encoder\EncoderFactory;
use Mateu\Shared\Serializer\Normalizer\NormalizerFactory;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    public static function create($type)
    {
        switch (true) {
            case $type === 'csv':
                return new Serializer(
                    NormalizerFactory::create(),
                    EncoderFactory::create()
                );
                break;
            default:
                break;
        }


    }

}