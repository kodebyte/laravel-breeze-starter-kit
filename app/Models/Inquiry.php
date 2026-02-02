<?php

namespace App\Models;

use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFilters;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 
        'is_read', 'ip_address', 'user_agent'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Helper buat Scope filter (misal: Inquiry::unread()->count())
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}