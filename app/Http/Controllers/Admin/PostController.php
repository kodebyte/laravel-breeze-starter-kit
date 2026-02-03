<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Services\ImageUploadService; // <--- Import Service
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller implements HasMiddleware
{
    // Inject Service via Constructor
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:posts.view', only: ['index']),
            new Middleware('permission:posts.create', only: ['create', 'store']),
            new Middleware('permission:posts.update', only: ['edit', 'update']),
            new Middleware('permission:posts.delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $posts = Post::query()
                ->with(['category', 'author']) // Eager Load
                ->filter($request->only(['search', 'sort', 'direction', 'status', 'category']))
                ->paginate($this->getPerPage())
                ->withQueryString();

        $categories = Category::where('is_active', true)
                        ->get(); // Buat filter dropdown di index

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->get();
        $statuses = PostStatus::cases();

        return view('admin.posts.create', compact('categories', 'statuses'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            
            // 1. Handle Image Upload (Auto WebP via Service)
            if ($request->hasFile('image')) {
                // Upload ke folder 'posts', resize width 1200px (opsional, sesuaikan kebutuhan)
                $data['image'] = $this->imageService->upload($request->file('image'), 'posts', 1200);
            }

            // 2. Assign Author (Employee ID dari User yang login)
            // Pastikan User punya relasi employee ya Bro!
            $data['employee_id'] = auth()->id();

            // 3. Create
            Post::create($data);

            return to_route('admin.posts.index')
                ->with('success', 'Post created successfully.');

        } catch (\Throwable $e) {
            Log::error('Error creating post: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create post.');
        }
    }

    public function edit(Post $post): View
    {
        $categories = Category::where('is_active', true)->get();
        $statuses = PostStatus::cases();

        return view('admin.posts.edit', compact('post', 'categories', 'statuses'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        try {
            $data = $request->validated();

            // 1. Handle Image Upload (Auto WebP via Service)
            if ($request->hasFile('image')) {
                // Delete old image using service
                $this->imageService->delete($post->image);
                
                // Upload new image
                $data['image'] = $this->imageService->upload($request->file('image'), 'posts', 1200);
            }

            // 2. Manual Slug override
            if ($request->filled('slug')) {
                $data['slug'] = Str::slug($request->slug);
            }

            // 3. Update
            $post->update($data);

            return to_route('admin.posts.index')
                ->with('success', 'Post updated successfully.');

        } catch (\Throwable $e) {
            Log::error('Error updating post ID ' . $post->id . ': ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update post.');
        }
    }

    public function destroy(Post $post): RedirectResponse
    {
        try {
            // Delete Image using Service
            $this->imageService->delete($post->image);

            $post->delete();

            return back()->with('success', 'Post deleted successfully.');

        } catch (\Throwable $e) {
            Log::error('Error deleting post ID ' . $post->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to delete post.');
        }
    }
}