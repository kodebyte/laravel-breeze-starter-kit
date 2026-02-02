<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use HasTranslations;

    protected $fillable = [
        'label', 
        'url', 
        'page_id', 
        'parent_id', 
        'order', 
        'target', 
        'is_active', 
        'icon_class'
    ];

    public $translatable = [
        'label'
    ];

    // Relasi ke Child (Sub-menu)
    // Diurutkan berdasarkan 'order' biar tampil sesuai drag-and-drop
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    // Relasi ke Parent
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    // Relasi ke Page (Kalau menu ini ngelink ke Static Page)
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}