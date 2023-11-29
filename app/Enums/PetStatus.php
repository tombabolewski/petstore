<?php

namespace App\Enums;

use ReflectionClass;

enum PetStatus: string
{
    case Available = 'available';
    case Pending = 'pending';
    case Sold = 'sold';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
