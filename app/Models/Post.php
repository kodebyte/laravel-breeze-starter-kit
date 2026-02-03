<?php

namespace App\Models;

use App\Enums\PostStatus; // <--- 1. IMPORT ENUM
use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasTranslations;
    
    // Gunakan Trait HasFilters dengan Alias
    use HasFilters {
        scopeFilter as scopeCommonFilter;
    }

    protected $fillable = [
        'category_id', 'employee_id', 'title', 'slug', 'excerpt', 
        'content', 'image', 'status', 'published_at', 'views_count'
    ];

    public $translatable = ['title', 'excerpt', 'content'];

    // Searchable fields untuk Trait HasFilters
    protected $searchable = [
        'title->id', 
        'title->en',
    ];

    /**
     * CASTING TIPE DATA
     */
    protected $casts = [
        'published_at' => 'datetime',
        'status' => PostStatus::class, // <--- 2. CASTING KE ENUM
    ];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // =========================================================================
    // BOOT & SCOPES
    // =========================================================================

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->getTranslation('title', 'id'));
            }
        });
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        // 1. Common Filter (Search/Sort)
        $this->scopeCommonFilter($query, $filters);

        // 2. Status Filter
        // Karena sudah di-cast, Laravel pintar.
        // Lo bisa pass string 'published' atau Enum PostStatus::PUBLISHED
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });
        
        // 3. Category Filter
        $query->when($filters['category'] ?? null, function ($query, $categorySlug) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        });
        
        // 4. Author Filter
        $query->when($filters['author'] ?? null, function ($query, $employeeId) {
            $query->where('employee_id', $employeeId);
        });
    }
}