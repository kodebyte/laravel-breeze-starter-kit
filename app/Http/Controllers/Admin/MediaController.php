<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\StoreMediaRequest;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class MediaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:media.view', only: ['index']),
            new Middleware('permission:media.delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        // MAGIC OF HASFILTERS:
        // Logic search & type filter otomatis jalan di sini
        $mediaItems = Media::query()
                        ->filter($request->only(['search', 'type', 'sort', 'direction']))
                        ->latest()
                        ->paginate(24) // Grid view biasanya paginate, bukan cursorPaginate
                        ->withQueryString();

        return view('admin.media.index', compact('mediaItems'));
    }

    public function store(StoreMediaRequest $request): RedirectResponse
    {
        try {
            // Logic Upload
            // Tetap nempel ke User yang login (sesuai diskusi sebelumnya)
            auth()->user()
                ->addMedia($request->file('file'))
                ->toMediaCollection('library');

            // Redirect Balik (Bukan JSON)
            return to_route('admin.media.index')
                    ->with('success', 'File uploaded successfully.');

        } catch (\Throwable $e) {
            \Log::error('Error uploading media: ' . $e->getMessage());

            return back()->with('error', 'Failed to upload file.');
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            // Pake Model custom Media
            $media = Media::findOrFail($id);
            $media->delete();

            return to_route('admin.media.index')
                ->with('success', 'File deleted permanently.');

        } catch (\Throwable $e) {
            \Log::error('Error deleting media ID ' . $id . ': ' . $e->getMessage());

            return back()->with('error', 'Failed to delete file.');
        }
    }
}