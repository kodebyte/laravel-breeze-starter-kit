<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests\Admin\Banner\StoreBannerRequest;
use App\Http\Requests\Admin\Banner\UpdateBannerRequest;
use App\Services\ImageUploadService; // <--- Import Service
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BannerController extends Controller implements HasMiddleware
{
    // Inject Service via Constructor
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

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
        $banners = Banner::orderBy('zone')->orderBy('order')->paginate(10);
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

            // Pake Service: Upload Desktop
            if ($request->hasFile('image_desktop')) {
                // Contoh: Resize ke lebar 1920px biar gak kegedean
                $data['image_desktop'] = $this->imageService->upload(
                    $request->file('image_desktop'), 
                    'banners', 
                    1920
                );
            }

            // Pake Service: Upload Mobile
            if ($request->hasFile('image_mobile')) {
                // Contoh: Resize ke lebar 1080px (Portrait)
                $data['image_mobile'] = $this->imageService->upload(
                    $request->file('image_mobile'), 
                    'banners', 
                    1080
                );
            }

            // Video tetap manual store karena bukan image
            if ($request->type === 'video' && $request->hasFile('video')) {
                $data['video_path'] = $request->file('video')->store('banners/video', 'public');
            }

            Banner::create($data);

            return to_route('admin.banners.index')->with('success', 'Banner created successfully.');

        } catch (\Throwable $e) {
            Log::error('Error creating banner: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create banner.');
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

            // 1. Desktop Image
            if ($request->hasFile('image_desktop')) {
                // Service: Hapus lama, Upload baru
                $this->imageService->delete($banner->image_desktop);
                $data['image_desktop'] = $this->imageService->upload(
                    $request->file('image_desktop'), 'banners', 1920
                );
            }

            // 2. Mobile Image
            if ($request->hasFile('image_mobile')) {
                $this->imageService->delete($banner->image_mobile);
                $data['image_mobile'] = $this->imageService->upload(
                    $request->file('image_mobile'), 'banners', 1080
                );
            }

            // 3. Video Logic
            if ($request->type === 'image' && $banner->video_path) {
                // Kalau ganti tipe ke image, hapus video lama manual (Service kita cuma handle image)
                $this->imageService->delete($banner->video_path); // Delete service bisa dipake buat file apa aja asal path bener
                $data['video_path'] = null;
            } 
            elseif ($request->type === 'video' && $request->hasFile('video')) {
                $this->imageService->delete($banner->video_path);
                $data['video_path'] = $request->file('video')->store('banners/video', 'public');
            }

            $banner->update($data);

            return to_route('admin.banners.index')->with('success', 'Banner updated successfully.');

        } catch (\Throwable $e) {
            Log::error('Error updating banner ID ' . $banner->id . ': ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update banner.');
        }
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        try {
            // Pake Service buat bersih-bersih
            $this->imageService->delete($banner->image_desktop);
            $this->imageService->delete($banner->image_mobile);
            $this->imageService->delete($banner->video_path);

            $banner->delete();

            return back()->with('success', 'Banner deleted successfully.');

        } catch (\Throwable $e) {
            Log::error('Error deleting banner ID ' . $banner->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to delete banner.');
        }
    }
}