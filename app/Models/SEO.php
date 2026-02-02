<?php

namespace App\Models;

use RalphJSmit\Laravel\SEO\Models\SEO as BaseSEO;
use Spatie\Translatable\HasTranslations;

class SEO extends BaseSEO
{
    use HasTranslations;

    // Kolom yang mau ditranslate
    public $translatable = [
        'title', 
        'description'
    ];
}