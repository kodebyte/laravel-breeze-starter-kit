<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\StoreEmployeeRequest;
use App\Http\Requests\Admin\Employee\UpdateEmployeeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class EmployeeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:employees.view', only: ['index']),
            new Middleware('permission:employees.create', only: ['create', 'store']),
            new Middleware('permission:employees.update', only: ['edit', 'update']),
            new Middleware('permission:employees.delete', only: ['destroy']),
            new Middleware('permission:employees.restore', only: ['restore']),
        ];
    }

    public function index(
        Request $request
    ): View
    {
        $employees = Employee::query()
                    ->with('roles') // Eager load roles
                    ->filter($request->only(['search', 'sort', 'direction']))
                    ->cursorPaginate($this->getPerPage())
                    ->withQueryString();

        return view('admin.employees.index', compact('employees'));
    }

    public function create(): View
    {
        $roles = Role::all(); 
        return view('admin.employees.create', compact('roles'));
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        try {
            $employee = Employee::create([
                'identifier' => $request->identifier,
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'status'     => $request->status,
            ]);

            $employee->assignRole($request->role);

            return to_route('admin.employees.index')
                    ->with('status', 'New employee successfully added.'); // Label Button: Create Employee

        } catch (\Throwable $e) {
            \Log::error('Error creating employee: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Failed to create employee. Please try again.');
        }
    }

    public function edit(
        Employee $employee
    ): View
    {
        $roles = Role::all();
        return view('admin.employees.edit', compact('employee', 'roles'));
    }

   public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        try {
            // 1. Prepare Data Update
            $data = [
                'identifier' => $request->identifier,
                'name'       => $request->name,
                'email'      => $request->email,
                'status'     => $request->status,
            ];

            // Cek Password ganti atau nggak
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // 2. Execute Update
            $employee->update($data);

            // 3. Sync Role (Spatie)
            $employee->syncRoles($request->role);

            return to_route('admin.employees.index')
                    ->with('status', 'Employee updated successfully.'); // Label Button: Update Employee
        } catch (\Throwable $e) {
            \Log::error('Error updating employee ID ' . $employee->id . ': ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to update employee.');
        }
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        try {
            $employee->delete(); // Soft Delete

            // 1. Simpan respons dasar (Sesuai standard UserController)
            $response = to_route('admin.employees.index')
                        ->with('status', 'Employee moved to trash.');

            // 2. Logic Permission: Cuma kasih tombol Undo kalau punya akses restore
            if (auth()->user()->can('employees.restore')) {
                $response->with('undo_route', route('admin.employees.restore', $employee->id));
            }

            return $response;
        } catch (\Throwable $e) {
            \Log::error('Error delete employee ID ' . $employee->id . ': ' . $e->getMessage());

            return back()->with('error', 'Failed to delete employee.');
        }
    }

    public function restore(string $id): RedirectResponse
    {
        try {
            $employee = Employee::withTrashed()->findOrFail($id);
            $employee->restore();

            return to_route('admin.employees.index')
                    ->with('status', 'Employee has been restored.');
        } catch (\Throwable $e) {
            \Log::error('Error updating employee ID ' . $id . ': ' . $e->getMessage());

            return back()->with('error', 'Failed to restore employee.');
        }
    }
}