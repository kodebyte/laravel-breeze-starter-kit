<?php

namespace App\Enums;

enum EmployeeStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended'; // Bisa nambah status lain kedepannya

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::SUSPENDED => 'Suspended',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'success', // Buat badge nanti
            self::INACTIVE => 'secondary',
            self::SUSPENDED => 'danger',
        };
    }
}