<?php

namespace App\Models;

use App\Enums\EmployeeStatus;
use App\Traits\HasActivityLogs;
use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class Employee extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, HasFilters, HasActivityLogs, InteractsWithMedia, SoftDeletes;

    protected $guard_name = 'employee'; 

    protected $fillable = [
        'identifier',
        'name',
        'email',
        'password',
        'must_change_password',
        'status',
    ];

    protected $searchable = [
        'identifier',
        'name',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'must_change_password' => 'boolean',
            'status' => EmployeeStatus::class
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // 1. WebP Conversion
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(80)
            ->nonQueued();

        // 2. Thumbnail Conversion
        // Ganti string 'contain' jadi Enum Fit::Contain
        $this->addMediaConversion('thumb')
            ->fit(Fit::Contain, 300, 300) 
            ->nonQueued();
    }
}