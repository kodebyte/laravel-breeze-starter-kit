<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log; // DB Facade dihapus karena gak pake transaction manual
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller implements HasMiddleware
{
    /**
     * Define Permissions
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:categories.view', only: ['index']),
            new Middleware('permission:categories.create', only: ['create', 'store']),
            new Middleware('permission:categories.update', only: ['edit', 'update']),
            new Middleware('permission:categories.delete', only: ['destroy']),
        ];
    }

    /**
     * List Categories
     */
   public function index(Request $request): View
    {
        // Logic Search & Sort udah pindah ke Model (via Trait + Override)
        $categories = Category::query()
            ->withCount('posts')
            ->filter($request->only(['search', 'sort', 'direction'])) // <--- BERSIH!
            ->paginate($this->getPerPage())
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show Create Form
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store Category
     * (NO TRANSACTION: Single Query Atomic)
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            Category::create([
                'name' => $request->name,
                'is_active' => $request->boolean('is_active', true),
                // Slug otomatis handled by Model
            ]);

            return to_route('admin.categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\Throwable $e) {
            Log::error('Error creating category: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to create category.');
        }
    }

    /**
     * Show Edit Form
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update Category
     * (NO TRANSACTION: Single Query Atomic)
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $data = [
                'name' => $request->name,
                'is_active' => $request->boolean('is_active'),
            ];

            // Logic manipulasi data ini ada di PHP level, bukan DB query
            // Jadi pas masuk $category->update(), itu tetep hitung 1 query.
            if ($request->filled('slug')) {
                $data['slug'] = Str::slug($request->slug);
            }

            $category->update($data);

            return to_route('admin.categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Throwable $e) {
            Log::error('Error updating category ID ' . $category->id . ': ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to update category.');
        }
    }

    /**
     * Delete Category
     * (NO TRANSACTION: Single Query Atomic)
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            // Check ini cuma READ query
            if ($category->posts()->exists()) {
                return back()->with('error', 'Cannot delete category containing posts.');
            }

            // Ini WRITE query (Single)
            $category->delete();

            return back()->with('success', 'Category deleted successfully.');

        } catch (\Throwable $e) {
            Log::error('Error deleting category ID ' . $category->id . ': ' . $e->getMessage());

            return back()->with('error', 'Failed to delete category.');
        }
    }
}