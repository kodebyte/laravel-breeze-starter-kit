<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class PageController extends Controller implements HasMiddleware
{
    /**
     * Define Permissions
     * Kita samain structure-nya kayak UserController lo.
     */
    public static function middleware(): array
    {
        return [
            // Permission khusus untuk Pages
            // Pastikan lo udah tambah 'pages.view' & 'pages.update' di Seeder
            new Middleware('permission:pages.view', only: ['index']),
            new Middleware('permission:pages.update', only: ['edit', 'update']),
        ];
    }

    /**
     * List semua halaman statis.
     */
    public function index(): View
    {
        // Kita ambil semua page. Biasanya gak banyak, jadi get() cukup.
        $pages = Page::query()
                    ->orderBy('name')
                    ->get();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show form edit SEO.
     */
    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Logic Simpan SEO.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        try {
            // 1. Ambil data input array 'seo' (Title, Desc, Canonical)
            $seoData = $request->input('seo', []);

            // 2. Handle Upload Image (OG Image) manual
            // Karena package SEO butuh string URL/Path, bukan object File
            if ($request->hasFile('seo_image')) {
                $request->validate([
                    'seo_image' => 'image|max:2048' // Max 2MB
                ]);

                // Simpan ke storage/public/seo
                $path = $request->file('seo_image')->store('seo', 'public');
                
                // Masukkan path ke array $seoData
                $seoData['image'] = $path; 
            }

            // 3. UPDATE VIA PACKAGE
            // Ini method sakti dari trait HasSEO
            $page->seo->update($seoData);
        } catch (\Throwable $e) {
            \Log::error('Error updating SEO for Page ID ' . $page->id . ': ' . $e->getMessage());

            return back()->with('error', 'Failed to update SEO settings.');
        }

        return to_route('admin.pages.index')
                ->with('success', 'SEO settings updated successfully!');
    }

    // Tambahin method ini di dalam class PageController
    public function sync(): RedirectResponse
    {
        // 1. Definisikan List Halaman Default Disini (Hardcode aman)
        // Ini "Source of Truth" halaman statis lo.
        $defaultPages = [
            ['slug' => 'home', 'name' => 'Homepage'],
            ['slug' => 'about', 'name' => 'About Us'],
            ['slug' => 'services', 'name' => 'Our Services'],
            ['slug' => 'contact', 'name' => 'Contact Us'],
            ['slug' => 'privacy', 'name' => 'Privacy Policy'],
            ['slug' => 'terms', 'name' => 'Terms of Service'],
        ];

        try {
            $count = 0;
            
            // 2. Loop dan Create kalau belum ada
            foreach ($defaultPages as $page) {
                // firstOrCreate: Cek slug, kalau ga ada baru buat.
                // Kalau udah ada, dia skip (safe update).
                $wasRecentlyCreated = Page::firstOrCreate(
                    ['slug' => $page['slug']], // Pencarian
                    ['name' => $page['name']]  // Data jika dibuat baru
                )->wasRecentlyCreated;

                if ($wasRecentlyCreated) {
                    $count++;
                }
            }

            if ($count > 0) {
                return back()->with('success', "Synced! Added {$count} new pages.");
            }
        } catch (\Throwable $e) {
            \Log::error('Sync Pages Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to sync pages.');
        }

        return back()->with('info', 'All pages are already synced.');
    }
}