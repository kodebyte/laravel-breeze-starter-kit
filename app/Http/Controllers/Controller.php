<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function getPerPage(): int
    {
        $perPage = request()->input('per_page', 20);
        
        // Validasi biar user iseng gak masukin angka 99999
        return in_array($perPage, [20, 40, 60, 80, 100]) ? $perPage : 20;
    }
}
