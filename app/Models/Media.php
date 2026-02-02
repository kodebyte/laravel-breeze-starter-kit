<?php

namespace App\Models;

use App\Traits\HasFilters; // Panggil Trait andalan lo
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media extends SpatieMedia
{
    use HasFilters;

    // 1. Definisikan kolom yang bisa di-search via HasFilters
    protected $searchable = [
        'name', 
        'file_name',
        'mime_type'
    ];

    // 2. Kita pindahin logic filter 'type' kesini (Scope)
    // Jadi nanti di controller tinggal panggil filter(['type' => 'image'])
    public function scopeType(Builder $query, $value): void
    {
        if ($value === 'image') {
            $query->where('mime_type', 'like', 'image/%');
        } elseif ($value === 'document') {
            $query->where('mime_type', 'not like', 'image/%');
        }
    }
}