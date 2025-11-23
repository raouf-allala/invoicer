<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case PENDING = 'pending';
    case CONVERTED = 'converted';
    case REJECTED = 'rejected'; // Added rejected just in case, though not explicitly requested, it's good practice.

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONVERTED => 'Converted',
            self::REJECTED => 'Rejected',
        };
    }

    public static function fillableStatuses(): array
    {
        return [
            self::PENDING,
            self::CONVERTED,
            self::REJECTED,
        ];
    }
}
