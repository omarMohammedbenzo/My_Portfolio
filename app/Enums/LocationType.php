<?php

namespace App\Enums;

enum LocationType: string
{
    case OnSite = 'on-site';
    case Remote = 'remote';
    case Hybrid = 'hybrid';

    public function label(): string
    {
        return match ($this) {
            self::OnSite => 'On-site',
            self::Remote => 'Remote',
            self::Hybrid => 'Hybrid',
        };
    }
}
