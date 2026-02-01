<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    /**
     * Apply search and sort filters dynamically.
     * Support Standard Relations and Polymorphic Relations (causer).
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        // 1. Logic Search
        if (isset($filters['search']) && $filters['search'] !== '' && !empty($this->searchable)) {
            $search = $filters['search'];
            
            $query->where(function ($q) use ($search) {
                foreach ($this->searchable as $key => $column) {
                    
                    // Support search di relasi (misal: 'causer.name' atau 'roles.name')
                    if (str_contains($column, '.')) {
                        [$relation, $field] = explode('.', $column);

                        // KHUSUS: Handle Polymorphic Causer (Activity Logs)
                        if ($relation === 'causer') {
                            $q->orWhereHasMorph($relation, ['App\Models\Employee', 'App\Models\User'], function ($subQ) use ($field, $search) {
                                $subQ->where($field, 'like', "%{$search}%");
                            });
                        } else {
                            // Relasi Standar (BelongsTo, HasOne, dll)
                            $q->orWhereHas($relation, function ($subQ) use ($field, $search) {
                                $subQ->where($field, 'like', "%{$search}%");
                            });
                        }
                    } else {
                        // Search kolom biasa di tabel utama
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
        if (isset($filters['sort']) && isset($filters['direction'])) {
            $query->orderBy($filters['sort'], $filters['direction']);
        } else {
            $query->latest();
        }

        return $query;
    }
}