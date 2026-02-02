<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasSEO, HasTranslations;

    protected $fillable = [
        'name', 
        'slug', 
        'content', 
        'is_editable'
        
    ];

    public $translatable = [
        'content'
    ];

    protected $casts = [
        'is_editable' => 'boolean',
    ];
}
