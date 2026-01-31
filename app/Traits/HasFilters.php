<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    /**
     * Apply search and sort filters dynamically.
     *
     * @param Builder $query
     * @param array $filters (Input dari request: search, sort, direction)
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        // 1. Logic Search
        if (isset($filters['search']) && $filters['search'] !== '' && !empty($this->searchable)) {
            $search = $filters['search'];
            
            $query->where(function ($q) use ($search) {
                foreach ($this->searchable as $key => $column) {
                    // Support search di relasi (misal: 'roles.name')
                    if (str_contains($column, '.')) {
                        [$relation, $field] = explode('.', $column);
                        $q->orWhereHas($relation, function ($subQ) use ($field, $search) {
                            $subQ->where($field, 'like', "%{$search}%");
                        });
                    } else {
                        // Search kolom biasa
                        if ($key === 0) {
                            $q->where($column, 'like', "%{$search}%");
                        } else {
                            $q->orWhere($column, 'like', "%{$search}%");
                        }
                    }
                }
            });
        }

        // 2. Logic Sort
        // Cek apakah kolom yang mau disort ada di $searchable atau diizinkan (bisa ditambah property $sortable kalau mau strict)
        if (isset($filters['sort']) && isset($filters['direction'])) {
            $query->orderBy($filters['sort'], $filters['direction']);
        } else {
            // Default Sort (bisa di-override di Model kalau mau)
            $query->latest();
        }

        return $query;
    }
}