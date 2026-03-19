<?php

namespace App\Enums;

enum FeeType: string
{
    case MONTHLY = 'monthly';
    case ADMISSION = 'admission';
    case EXAMINATION = 'examination';

    public function label(): string
    {
        return match ($this) {
            self::MONTHLY => 'Monthly Fee',
            self::ADMISSION => 'Admission Fee',
            self::EXAMINATION => 'Examination Fee',
        };
    }
}
