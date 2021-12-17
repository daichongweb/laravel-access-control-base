<?php

namespace App\Enums;

class CommonStatus
{
    const ENABLE = 1;

    const DISABLE = 0;

    public static function map(): array
    {
        return [
            self::DISABLE,
            self::ENABLE
        ];
    }
}
