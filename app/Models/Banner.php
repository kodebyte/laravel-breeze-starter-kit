<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Banner extends Model
{
    protected $fillable = [
        'zone', 'type', 
        'image_desktop', 'image_mobile', 'video_path',
        'title', 'subtitle', 'cta_text', 'cta_url',
        'order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get Zones from Config
     */
    public static function getZones()
    {
        return config('cms.banner_zones', []);
    }

    /**
     * Scope for Frontend: Banner::zone('home_hero')->get();
     */
    public function scopeZone(Builder $query, string $zone): void
    {
        $query->where('zone', $zone)
              ->where('is_active', true)
              ->orderBy('order', 'asc');
    }
}