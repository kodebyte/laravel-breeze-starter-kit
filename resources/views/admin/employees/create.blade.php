<x-admin.layouts.app title="Add New Employee">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Employees' => route('admin.employees.index'), 
                    'Add New' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Add New Employee
                </h2>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf

        {{-- SINGLE CARD LAYOUT --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8">
                
                {{-- SECTION 1: PROFESSIONAL PROFILE --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            {{-- Pake icon Briefcase biar beda dikit sama User biasa --}}
                            <x-admin.icon.briefcase class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Professional Profile</h3>
                            <p class="text-xs text-gray-500">Employee identification and role assignment.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3"> {{-- Gap 3 (Rapat & Rapi) --}}
                        
                        {{-- Row 1: ID & Name --}}
                        <x-admin.form.group label="Employee ID" name="identifier" required>
                            <x-admin.form.input name="identifier" placeholder="e.g. KB-001" required autofocus />
                        </x-admin.form.group>

                        <x-admin.form.group label="Full Name" name="name" required>
                            <x-admin.form.input name="name" placeholder="Enter full name" required />
                        </x-admin.form.group>

                        {{-- Row 2: Email (Full Width) --}}
                        <div class="md:col-span-2">
                            <x-admin.form.group label="Email Address" name="email" required>
                                <x-admin.form.input type="email" name="email" placeholder="email@company.com" required />
                            </x-admin.form.group>
                        </div>

                        {{-- Row 3: Role & Status --}}
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
                                @foreach(\App\Enums\EmployeeStatus::cases() as $status)
                                    <option value="{{ $status->value }}" {{ $status->value === 'active' ? 'selected' : '' }}>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </x-admin.form.select>
                        </x-admin.form.group>

                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: SECURITY (AUTOMATED info) --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                            <x-admin.icon.lock class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Security Access</h3>
                            <p class="text-xs text-gray-500">System generated credentials.</p>
                        </div>
                    </div>

                    {{-- Info Box yang sudah dipercantik --}}
                    <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-xl flex items-start gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm text-blue-600">
                            <x-admin.icon.info class="w-5 h-5" />
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 leading-none mb-1">Automated Password Generation</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                The system will automatically generate a secure random password and send the login credentials directly to the employee's email address above.
                            </p>
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
                    Create Employee
                </x-admin.ui.button>
            </div>
            
        </div>
    </form>
</x-admin.layouts.app>