<?php

namespace App\Enums;

enum SkillCategory: string
{
    case Frontend = 'frontend';
    case Backend  = 'backend';
    case Tools    = 'tools';
    case Other    = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Frontend => 'Front-End',
            self::Backend  => 'Back-End',
            self::Tools    => 'Tools & DevOps',
            self::Other    => 'Other',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Frontend => 'blue',
            self::Backend  => 'violet',
            self::Tools    => 'emerald',
            self::Other    => 'slate',
        };
    }
}
