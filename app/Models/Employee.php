<?php

namespace App\Models;

use App\Enums\EmployeeStatus;
use App\Traits\HasActivityLogs;
use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasFilters, HasActivityLogs, SoftDeletes;

    protected $guard_name = 'employee'; 

    protected $fillable = [
        'identifier',
        'name',
        'email',
        'password',
        'must_change_password',
        'status',
    ];

    protected $searchable = [
        'identifier',
        'name',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'must_change_password' => 'boolean',
            'status' => EmployeeStatus::class
        ];
    }
}