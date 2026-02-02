<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class InquiryController extends Controller implements HasMiddleware
{
    /**
     * Define Permissions
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:inquiries.view', only: ['index', 'show']),
            new Middleware('permission:inquiries.delete', only: ['destroy']),
        ];
    }

    /**
     * List Pesan Masuk
     */
    public function index(Request $request): View
    {
        $inquiries = Inquiry::query()
                        ->filter($request->only(['search', 'sort', 'direction']))
                        ->orderBy('is_read', 'asc') // Yang belum dibaca ditaruh paling atas
                        ->orderBy('created_at', 'desc') // Terus urutkan dari yang terbaru
                        ->paginate(10);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Baca Detail Pesan
     */
    public function show(Inquiry $inquiry): View
    {
        // Auto-mark as Read pas dibuka
        if (!$inquiry->is_read) {
            $inquiry->update(['is_read' => true]);
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Hapus Pesan (Misal SPAM)
     */
    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        try {
            $inquiry->delete();
            return back()->with('success', 'Message deleted successfully.');
        } catch (\Throwable $e) {
            \Log::error('Error deleting inquiry ID ' . $inquiry->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to delete message.');
        }
    }
}