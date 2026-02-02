<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\UpdatePageRequest; // Import Request Baru
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class PageController extends Controller implements HasMiddleware
{
    /**
     * Define Permissions (Strict & Explicit)
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:pages.view', only: ['index']),
            new Middleware('permission:pages.update', only: ['edit', 'update', 'sync']),
        ];
    }

    /**
     * List semua halaman statis.
     */
    public function index(): View
    {
        $pages = Page::query()
                    ->orderBy('name')
                    ->get();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show form edit SEO & Content.
     */
    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update SEO & Page Content.
     */
    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        try {
            // Gunakan Transaction biar aman
            \DB::transaction(function () use ($request, $page) {
                
                // 1. UPDATE CONTENT (WYSIWYG)
                // PENTING: Pake $request->input('content') bukan $request->content
                if ($page->is_editable && $request->has('content')) {
                    $page->update([
                        // FIX DISINI:
                        'content' => $request->input('content') 
                        // Atau bisa juga: $request->validated('content')
                    ]);
                }

                // 2. PREPARE SEO DATA
                $seoData = $request->input('seo', []);

                // 3. HANDLE IMAGE UPLOAD (OG Image)
                if ($request->hasFile('seo_image')) {
                    $path = $request->file('seo_image')->store('seo', 'public');
                    $seoData['image'] = $path; 
                }

                // 4. UPDATE SEO PACKAGE
                $page->seo->update($seoData);
            });

            return to_route('admin.pages.index')
                    ->with('success', 'Page settings updated successfully.');

        } catch (\Throwable $e) {
            \Log::error('Error updating Page ID ' . $page->id . ': ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to update page settings.');
        }
    }

    /**
     * Sync Default Pages (Safe Create).
     */
    public function sync(): RedirectResponse
    {
        // "Source of Truth" halaman statis
        $defaultPages = [
            ['slug' => 'home',     'name' => 'Homepage',       'is_editable' => false], // Hardcoded view
            ['slug' => 'about',    'name' => 'About Us',       'is_editable' => false], // Hardcoded view
            ['slug' => 'services', 'name' => 'Our Services',   'is_editable' => false], // Hardcoded view
            ['slug' => 'contact',  'name' => 'Contact Us',     'is_editable' => false], // Hardcoded view
            
            ['slug' => 'privacy',  'name' => 'Privacy Policy',   'is_editable' => true], // Database content
            ['slug' => 'terms',    'name' => 'Terms of Service', 'is_editable' => true], // Database content
        ];

        try {
            $count = 0;
            
            foreach ($defaultPages as $pageData) {
                $page = Page::firstOrCreate(
                    ['slug' => $pageData['slug']], // Kunci pencarian
                    [
                        'name' => $pageData['name'],
                        'is_editable' => $pageData['is_editable'] ?? false
                    ] 
                );

                if ($page->wasRecentlyCreated) {
                    $count++;
                }
            }

            if ($count > 0) {
                return back()->with('success', "Synced! Added {$count} new pages.");
            }

            return back()->with('info', 'All pages are already synced.');

        } catch (\Throwable $e) {
            \Log::error('Sync Pages Error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to sync pages.');
        }
    }
}