<?php

namespace App\Models;

use App\Traits\HasFilters; // <--- 1. Import Trait
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasTranslations;
    
    // 2. Pake Trait tapi ganti nama method aslinya
    use HasFilters {
        scopeFilter as scopeCommonFilter;
    }

    protected $fillable = ['name', 'slug', 'is_active'];
    
    public $translatable = ['name'];

    protected $casts = ['is_active' => 'boolean'];

    // 3. Define Searchable (Support JSON path syntax MySQL)
    protected $searchable = [
        'name->id',
        'name->en',
    ];

    // ... (Boot method tetap sama) ...
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $nameSource = $category->getTranslation('name', 'id') ?? 'category';
                $category->slug = Str::slug($nameSource);
            }
        });
    }

    // ... (Relation tetap sama) ...
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 4. OVERRIDE SCOPE FILTER
     * Disini kita kombinasiin Trait + Logic JSON Sort
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        // A. Panggil Logic Standar Trait (Search aman, tapi Sort mungkin salah)
        $this->scopeCommonFilter($query, $filters);

        // B. Fix Logic Sorting
        if (isset($filters['sort']) && $filters['sort'] === 'name') {
            
            // 1. Reset sorting bawaan Trait (karena dia sort string JSON)
            $query->reorder();
            
            // 2. Apply sorting JSON yang benar (Sort by Name ID)
            $direction = $filters['direction'] ?? 'asc';
            $query->orderByRaw("json_unquote(json_extract(name, '$.id')) $direction");
        
        } elseif (isset($filters['sort']) && $filters['sort'] === 'posts_count') {
            
            // Handle aggregate sort (jumlah artikel)
            $query->reorder();
            $query->orderBy('posts_count', $filters['direction'] ?? 'desc');
        }
    }
}