<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Draft     = 'draft';
    case Published = 'published';
    case Archived  = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft     => 'Draft',
            self::Published => 'Published',
            self::Archived  => 'Archived',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Draft     => 'yellow',
            self::Published => 'green',
            self::Archived  => 'slate',
        };
    }
}
