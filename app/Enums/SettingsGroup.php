<?php

namespace App\Enums;

enum SettingsGroup: string
{
    case Seo        = 'seo';
    case Social     = 'social';
    case Telegram   = 'telegram';
    case General    = 'general';
    case Images     = 'images';
    case Appearance = 'appearance';
    case Home       = 'home';

    public function label(): string
    {
        return match ($this) {
            self::Seo        => 'SEO & Meta',
            self::Social     => 'Social Links',
            self::Telegram   => 'Telegram Notifications',
            self::General    => 'General',
            self::Images     => 'Images & Media',
            self::Appearance => 'Appearance',
            self::Home       => 'Hero & Home Page',
        };
    }
}
