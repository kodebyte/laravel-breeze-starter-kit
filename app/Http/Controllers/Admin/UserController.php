<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

// Note: Gak perlu 'use DB' lagi

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $this->getPerPage();

        $users = User::query() // Gak ada with('roles') lagi
            ->filter($request->only(['search', 'sort', 'direction']))
            ->cursorPaginate($perPage)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Gak perlu kirim $roles lagi ke view
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            // SINGLE QUERY: Langsung Create aja
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return to_route('admin.users.index')
                ->with('status', 'User created successfully!');

        } catch (\Throwable $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create user.');
        }
    }

    public function edit(User $user)
    {
        // Gak perlu kirim $roles
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
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
                ->with('status', 'User updated successfully!');

        } catch (\Throwable $e) {
            Log::error('Error updating user ID ' . $user->id . ': ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update user.');
        }
    }

    public function destroy(User $user)
    {
        try {
            // SINGLE QUERY: Delete
            $user->delete();

            return to_route('admin.users.index')
                ->with('status', 'User deleted successfully!');
                
        } catch (\Throwable $e) {
            Log::error('Error deleting user ID ' . $user->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to delete user.');
        }
    }
}