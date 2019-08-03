<?php

namespace Mateu\Shared\Domain\ValueObject\Uuid;

class UuidGenerator
{
    public static function generate()
    {
        $data = random_bytes(16);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
