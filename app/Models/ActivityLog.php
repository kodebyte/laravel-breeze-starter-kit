<?php

namespace App\Models;

use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFilters; // Pakai ini biar konsisten sama UserController

    protected $fillable = [
        'log_name',
        'description',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    protected array $searchable = [
        'description', // Buat nyari aksi (misal: "Created", "Deleted")
        'log_name',    // Buat nyari nama modelnya (misal: "employee", "role")
        'ip_address',  // Penting buat audit kalau ada aktivitas mencurigakan dari IP tertentu
        'causer.name'
    ];

    /**
     * Relasi ke Pelaku (Admin/Employee)
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }
}