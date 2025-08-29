<?php

namespace App\Entity;

enum DangerLevelEnum: string
{
    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';
    case CRITICAL = 'Critical';

    public function priority(): int
    {
        return match ($this) {
            self::LOW => 1,
            self::MEDIUM => 2,
            self::HIGH => 3,
            self::CRITICAL => 4,
        };
    }

    public static function max(self $a, self $b): self
    {
        return $a->priority() >= $b->priority() ? $a : $b;
    }
}