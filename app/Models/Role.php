<?php

namespace App\Models;

use App\Traits\HasActivityLogs;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasActivityLogs;

    protected $guard_name = 'employee'; 
}