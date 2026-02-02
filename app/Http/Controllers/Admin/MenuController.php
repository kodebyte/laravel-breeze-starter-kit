<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// Import Request yang baru dibuat
use App\Http\Requests\Admin\Menu\StoreMenuRequest;
use App\Http\Requests\Admin\Menu\UpdateMenuRequest;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request; // Masih butuh buat updateTree & index
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class MenuController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:menus.view', only: ['index']),
            new Middleware('permission:menus.create', only: ['store']),
            new Middleware('permission:menus.update', only: ['update', 'updateTree']),
            new Middleware('permission:menus.delete', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $menuItems = MenuItem::whereNull('parent_id')
            ->orderBy('order')
            ->with('children') 
            ->get();

        $pages = Page::orderBy('name')->get();

        return view('admin.menus.index', compact('menuItems', 'pages'));
    }

    /**
     * Store pakai StoreMenuRequest
     */
    public function store(StoreMenuRequest $request): RedirectResponse
    {
        // GAK PERLU VALIDASI MANUAL LAGI DISINI
        // Kalau masuk sini, berarti data udah valid & aman.
        
        try {
            MenuItem::create([
                'label'     => $request->label,
                'page_id'   => $request->type === 'page' ? $request->page_id : null,
                'url'       => $request->type === 'custom' ? $request->url : null,
                'target'    => $request->target ?? '_self',
                'order'     => MenuItem::max('order') + 1,
                'is_active' => true,
            ]);

            return back()->with('success', 'Menu item added successfully.');

        } catch (\Throwable $e) {
            \Log::error('Error creating menu item: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create menu item.');
        }
    }

    /**
     * Update pakai UpdateMenuRequest
     */
    public function update(UpdateMenuRequest $request, MenuItem $menu): RedirectResponse
    {
        try {
            $data = [];

            // Handle Visibility Toggle
            if ($request->has('is_active')) {
                $data['is_active'] = $request->boolean('is_active');
            }

            // Handle Data Update
            if ($request->has('label')) {
                $data['label'] = $request->label;
            }
            if ($request->has('url')) {
                $data['url'] = $request->url;
            }
            if ($request->has('target')) {
                $data['target'] = $request->target;
            }

            $menu->update($data);

            return back()->with('success', 'Menu updated successfully.');

        } catch (\Throwable $e) {
            \Log::error('Error updating menu ID ' . $menu->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to update menu item.');
        }
    }

    public function destroy(MenuItem $menu): RedirectResponse
    {
        try {
            $menu->delete();
            return back()->with('success', 'Menu item deleted.');
        } catch (\Throwable $e) {
            \Log::error('Error deleting menu ID ' . $menu->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to delete menu item.');
        }
    }

    // ... updateTree dan saveTree tetap sama (karena pake Request biasa/AJAX) ...
    public function updateTree(Request $request): JsonResponse
    {
         // ... Kodingan updateTree yang tadi ...
         // (Gak perlu diganti karena validasinya spesifik array structure)
         $tree = $request->input('tree');
         if (!is_array($tree)) return response()->json(['status' => 'error'], 400);

         try {
            \DB::transaction(function () use ($tree) {
                $this->saveTree($tree, null);
            });
            return response()->json(['status' => 'success']);
         } catch (\Throwable $e) {
             \Log::error('Tree Error: ' . $e->getMessage());
             return response()->json(['status' => 'error'], 500);
         }
    }

    private function saveTree(array $items, ?int $parentId): void
    {
        foreach ($items as $index => $item) {
            $menu = MenuItem::find($item['id']);
            if ($menu) {
                $menu->update(['parent_id' => $parentId, 'order' => $index + 1]);
                if (!empty($item['children'])) {
                    $this->saveTree($item['children'], $menu->id);
                }
            }
        }
    }
}