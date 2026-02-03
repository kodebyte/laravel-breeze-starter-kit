<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;

class Banner extends Model
{
    use HasTranslations;

    protected $fillable = [
        'zone', 'type', 
        'image_desktop', 'image_mobile', 'video_path',
        'title', 'subtitle', 'cta_text', 'cta_url',
        'order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'title', 
        'subtitle', 
        'cta_text', 
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