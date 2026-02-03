<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests\Admin\Banner\StoreBannerRequest;
use App\Http\Requests\Admin\Banner\UpdateBannerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BannerController extends Controller implements HasMiddleware
{
    /**
     * Standard Middleware Implementation
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:banners.view', only: ['index']),
            new Middleware('permission:banners.create', only: ['create', 'store']),
            new Middleware('permission:banners.update', only: ['edit', 'update']),
            new Middleware('permission:banners.delete', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $banners = Banner::query()
            ->orderBy('zone')
            ->orderBy('order')
            ->paginate(10);

        return view('admin.banners.index', compact('banners'));
    }

    public function create(): View
    {
        $zones = Banner::getZones();
        return view('admin.banners.create', compact('zones'));
    }

    public function store(StoreBannerRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // 1. Upload Desktop Image
            if ($request->hasFile('image_desktop')) {
                $data['image_desktop'] = $request->file('image_desktop')->store('banners', 'public');
            }

            // 2. Upload Mobile Image
            if ($request->hasFile('image_mobile')) {
                $data['image_mobile'] = $request->file('image_mobile')->store('banners', 'public');
            }

            // 3. Upload Video
            if ($request->type === 'video' && $request->hasFile('video')) {
                $data['video_path'] = $request->file('video')->store('banners/video', 'public');
            }

            Banner::create($data);

            return to_route('admin.banners.index')
                ->with('success', 'Banner created successfully.');

        } catch (\Throwable $e) {
            Log::error('Error creating banner: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create banner: ' . $e->getMessage());
        }
    }

    public function edit(Banner $banner): View
    {
        $zones = Banner::getZones();
        return view('admin.banners.edit', compact('banner', 'zones'));
    }

    public function update(UpdateBannerRequest $request, Banner $banner): RedirectResponse
    {
        try {
            $data = $request->validated();

            // 1. Handle Desktop Image Update
            if ($request->hasFile('image_desktop')) {
                // Hapus file lama
                if ($banner->image_desktop) {
                    Storage::disk('public')->delete($banner->image_desktop);
                }
                $data['image_desktop'] = $request->file('image_desktop')->store('banners', 'public');
            }

            // 2. Handle Mobile Image Update
            if ($request->hasFile('image_mobile')) {
                if ($banner->image_mobile) {
                    Storage::disk('public')->delete($banner->image_mobile);
                }
                $data['image_mobile'] = $request->file('image_mobile')->store('banners', 'public');
            }

            // 3. Handle Video Update
            // Scenario A: Tipe berubah jadi Image -> Hapus video lama
            if ($request->type === 'image' && $banner->video_path) {
                Storage::disk('public')->delete($banner->video_path);
                $data['video_path'] = null;
            } 
            // Scenario B: Upload video baru -> Hapus video lama & simpan baru
            elseif ($request->type === 'video' && $request->hasFile('video')) {
                if ($banner->video_path) {
                    Storage::disk('public')->delete($banner->video_path);
                }
                $data['video_path'] = $request->file('video')->store('banners/video', 'public');
            }

            $banner->update($data);

            return to_route('admin.banners.index')
                ->with('success', 'Banner updated successfully.');

        } catch (\Throwable $e) {
            Log::error('Error updating banner ID ' . $banner->id . ': ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update banner: ' . $e->getMessage());
        }
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        try {
            // Cleanup Files
            if ($banner->image_desktop) Storage::disk('public')->delete($banner->image_desktop);
            if ($banner->image_mobile) Storage::disk('public')->delete($banner->image_mobile);
            if ($banner->video_path) Storage::disk('public')->delete($banner->video_path);

            $banner->delete();

            return back()->with('success', 'Banner deleted successfully.');

        } catch (\Throwable $e) {
            Log::error('Error deleting banner ID ' . $banner->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to delete banner.');
        }
    }
}