<x-admin.layouts.app title="Edit Employee">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Employees' => route('admin.employees.index'), 
                    'Edit' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Edit Employee: <span class="text-primary">{{ $employee->name }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
        @csrf
        @method('PUT')

        {{-- SINGLE CARD LAYOUT --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8">
                
                {{-- SECTION 1: PROFESSIONAL PROFILE --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <x-admin.icon.briefcase class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Professional Profile</h3>
                            <p class="text-xs text-gray-500">Update employee details and access level.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        
                        <x-admin.form.group label="Employee ID" name="identifier" required>
                            <x-admin.form.input name="identifier" :value="old('identifier', $employee->identifier)" required />
                        </x-admin.form.group>

                        <x-admin.form.group label="Full Name" name="name" required>
                            <x-admin.form.input name="name" :value="old('name', $employee->name)" required />
                        </x-admin.form.group>

                        <div class="md:col-span-2">
                            <x-admin.form.group label="Email Address" name="email" required>
                                <x-admin.form.input type="email" name="email" :value="old('email', $employee->email)" required />
                            </x-admin.form.group>
                        </div>

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

                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: SECURITY ACCESS --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                            <x-admin.icon.lock class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Security Access</h3>
                            <p class="text-xs text-gray-500">Leave blank if you don't want to change the password.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <x-admin.form.group label="New Password" name="password">
                            <x-admin.form.input type="password" name="password" autocomplete="new-password" placeholder="Min. 8 characters" />
                        </x-admin.form.group>

                        <x-admin.form.group label="Confirm New Password" name="password_confirmation">
                            <x-admin.form.input type="password" name="password_confirmation" placeholder="Re-type password" />
                        </x-admin.form.group>

                        {{-- Checkbox "Must Change Password" --}}
                        <div class="md:col-span-2 pt-2">
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-center h-5">
                                    <x-admin.form.checkbox id="must_change_password" name="must_change_password" value="1" />
                                </div>
                                <div class="ml-1">
                                    <label for="must_change_password" class="text-sm font-bold text-gray-700 select-none">
                                        Force Password Reset
                                    </label>
                                    <p class="text-xs text-gray-500">User will be required to set a new password upon next login.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- FOOTER CARD --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.employees.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <x-admin.ui.button type="submit">
                    Update Employee
                </x-admin.ui.button>
            </div>
            
        </div>
    </form>
</x-admin.layouts.app>