<?php

namespace App\Enums;

enum EmploymentType: string
{
    case FullTime   = 'full-time';
    case PartTime   = 'part-time';
    case Contract   = 'contract';
    case Freelance  = 'freelance';
    case Internship = 'internship';

    public function label(): string
    {
        return match ($this) {
            self::FullTime   => 'Full Time',
            self::PartTime   => 'Part Time',
            self::Contract   => 'Contract',
            self::Freelance  => 'Freelance',
            self::Internship => 'Internship',
        };
    }
}
