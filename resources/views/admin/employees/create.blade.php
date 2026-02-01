<x-admin.layouts.app>
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="['Employees' => route('admin.employees.index'), 'Add New' => '#']" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">Add New Employee</h2>
    </x-slot>

    <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- 1. Identifier & Name --}}
                <x-admin.form.group label="Employee ID" name="identifier" required>
                    <x-admin.form.input name="identifier" placeholder="e.g. KB-001" required autofocus />
                </x-admin.form.group>

                <x-admin.form.group label="Full Name" name="name" required>
                    <x-admin.form.input name="name" placeholder="Enter full name" required />
                </x-admin.form.group>

                {{-- 2. Email (Full Width) --}}
                <div class="md:col-span-2">
                    <x-admin.form.group label="Email Address" name="email" required>
                        <x-admin.form.input type="email" name="email" placeholder="email@company.com" required />
                    </x-admin.form.group>
                </div>

                {{-- 3. Role & Status (Side by Side) --}}
                <x-admin.form.group label="Assign Role" name="role" required>
                    <x-admin.form.select name="role" required>
                        <option value="" disabled selected>-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </x-admin.form.select>
                </x-admin.form.group>

                <x-admin.form.group label="Employee Status" name="status" required>
                    <x-admin.form.select name="status" required>
                        {{-- Loop Enum EmployeeStatus --}}
                        @foreach(\App\Enums\EmployeeStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ $status->value === 'active' ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </x-admin.form.select>
                </x-admin.form.group>

                <div class="md:col-span-2 border-t border-gray-100 my-2"></div>

                {{-- 4. Password --}}
                <x-admin.form.group label="Password" name="password" required>
                    <x-admin.form.input type="password" name="password" required placeholder="Min. 8 characters" />
                </x-admin.form.group>

                <x-admin.form.group label="Confirm Password" name="password_confirmation" required>
                    <x-admin.form.input type="password" name="password_confirmation" required placeholder="Re-type password" />
                </x-admin.form.group>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
                <a href="{{ route('admin.employees.index') }}" class="text-sm text-gray-500 font-medium py-2">Cancel</a>
                {{-- Button Label sesuai kesepakatan --}}
                <x-admin.ui.button>Create Employee</x-admin.ui.button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>