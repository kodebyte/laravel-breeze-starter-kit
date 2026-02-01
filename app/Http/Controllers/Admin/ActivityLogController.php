<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ActivityLogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('permission:logs.view')];
    }

    public function index(Request $request): View
    {
        // Menggunakan standard filter() sesuai UserController
        $logs = ActivityLog::query()
                    ->with('causer')
                    ->filter($request->only(['search', 'sort', 'direction'])) // Konsisten bro!
                    ->latest()
                    ->cursorPaginate($this->getPerPage())
                    ->withQueryString();

        return view('admin.logs.index', compact('logs'));
    }

    public function show(string $id): View
    {
        // Ambil data log beserta pelaku aksinya
        $log = ActivityLog::with('causer')->findOrFail($id);

        return view('admin.logs.show', compact('log'));
    }
}