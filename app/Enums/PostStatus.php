<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    /**
     * Label yang akan tampil di UI (Dropdown/Table).
     */
    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::ARCHIVED => 'Archived',
        };
    }

    /**
     * Warna Badge untuk component UI.
     * (gray, green, red, yellow, dll sesuai component lo)
     */
    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',      // Abu-abu
            self::PUBLISHED => 'green', // Hijau
            self::ARCHIVED => 'rose',   // Merah muda/Merah
        };
    }
}