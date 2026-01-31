<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // Kita extend biar kalau nanti mau nambah relation custom enak.
    // Contoh: Role 'Manager' punya relasi ke 'Department'.
    
    // Default guard employee biar gak ribet set manual terus
    protected $guard_name = 'employee'; 
}