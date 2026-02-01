<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

// Note: Gak perlu 'use DB' lagi

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:users.view', only: ['index']),
            new Middleware('permission:users.create', only: ['create', 'store']),
            new Middleware('permission:users.update', only: ['edit', 'update']),
            new Middleware('permission:users.delete', only: ['destroy']),
            new Middleware('permission:users.restore', only: ['restore']),
        ];
    }

    public function index(Request $request): View
    {
        $users = User::query() // Gak ada with('roles') lagi
                    ->filter($request->only(['search', 'sort', 'direction']))
                    ->cursorPaginate($this->getPerPage())
                    ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        // Gak perlu kirim $roles lagi ke view
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            // SINGLE QUERY: Langsung Create aja
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return to_route('admin.users.index')
                    ->with('success', 'User created successfully!');

        } catch (\Throwable $e) {
            \Log::error('Error creating user: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to create user.');
        }
    }

    public function edit(User $user): View
    {
        // Gak perlu kirim $roles
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            // SINGLE PROCESS: Update atribut
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save(); // Single Query Save

            return to_route('admin.users.index')
                    ->with('success', 'User updated successfully!');

        } catch (\Throwable $e) {
            \Log::error('Error updating user ID ' . $user->id . ': ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to update user.');
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
            
            return to_route('admin.users.index')
                    ->with('success', 'User deleted.')
                    ->with('undo_route', route('admin.users.restore', $user->id));

        } catch (\Throwable $e) {
            \Log::error('Error delete user ID ' . $user->id . ': ' . $e->getMessage());

            return back()->with('error', 'Failed to delete user.');
        }
    }

    // Method Baru: Restore
    public function restore(string $id): RedirectResponse
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();

            return to_route('admin.users.index')
                    ->with('success', 'User has been restored.');
                
        } catch (\Throwable $e) {
            \Log::error('Error updating user ID ' . $id . ': ' . $e->getMessage());

            return back()->with('error', 'Failed to restore user.');
        }
    }
}