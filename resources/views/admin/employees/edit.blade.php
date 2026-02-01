<x-admin.layouts.app>
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="['Employees' => route('admin.employees.index'), 'Edit' => '#']" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            Edit Employee: <span class="text-primary">{{ $employee->name }}</span>
        </h2>
    </x-slot>

    <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- 1. Identifier & Name --}}
                <x-admin.form.group label="Employee ID" name="identifier" required>
                    <x-admin.form.input name="identifier" :value="old('identifier', $employee->identifier)" required />
                </x-admin.form.group>

                <x-admin.form.group label="Full Name" name="name" required>
                    <x-admin.form.input name="name" :value="old('name', $employee->name)" required />
                </x-admin.form.group>

                {{-- 2. Email --}}
                <div class="md:col-span-2">
                    <x-admin.form.group label="Email Address" name="email" required>
                        <x-admin.form.input type="email" name="email" :value="old('email', $employee->email)" required />
                    </x-admin.form.group>
                </div>

                {{-- 3. Role & Status --}}
                <x-admin.form.group label="Assign Role" name="role" required>
                    <x-admin.form.select name="role" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role', $employee->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </x-admin.form.select>
                </x-admin.form.group>

                <x-admin.form.group label="Employee Status" name="status" required>
                    <x-admin.form.select name="status" required>
                        @foreach(\App\Enums\EmployeeStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', $employee->status->value) == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </x-admin.form.select>
                </x-admin.form.group>

                <div class="md:col-span-2 border-t border-gray-100 my-2"></div>

                {{-- 4. Password (Optional) --}}
                <div class="md:col-span-2">
                    <h3 class="text-sm font-bold text-gray-900">Security</h3>
                    <p class="text-xs text-gray-500">Leave blank if you don't want to change the password.</p>
                </div>

                <x-admin.form.group label="New Password" name="password">
                    <x-admin.form.input type="password" name="password" autocomplete="new-password" placeholder="Min. 8 characters" />
                </x-admin.form.group>

                <x-admin.form.group label="Confirm New Password" name="password_confirmation">
                    <x-admin.form.input type="password" name="password_confirmation" placeholder="Re-type password" />
                </x-admin.form.group>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
                <a href="{{ route('admin.employees.index') }}" class="text-sm text-gray-500 font-medium py-2">Cancel</a>
                {{-- Button Label sesuai kesepakatan --}}
                <x-admin.ui.button>Update Employee</x-admin.ui.button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>