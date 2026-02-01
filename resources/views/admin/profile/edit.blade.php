<x-admin.layouts.app title="Profile Settings">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Profile Settings' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    My Profile
                </h2>
            </div>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')

        {{-- SINGLE CARD LAYOUT --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8">
                
                {{-- SECTION 1: BASIC INFORMATION --}}
                <div>
                    {{-- Header dengan Icon Biru (User) --}}
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <x-admin.icon.user-circle class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Basic Information</h3>
                            <p class="text-xs text-gray-500">Update your account's profile information and email address.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-admin.form.group label="Full Name" name="name" required>
                            <x-admin.form.input name="name" :value="old('name', $employee->name)" required />
                        </x-admin.form.group>

                        <x-admin.form.group label="Email Address" name="email" required>
                            <x-admin.form.input type="email" name="email" :value="old('email', $employee->email)" required />
                        </x-admin.form.group>
                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: SECURITY --}}
                <div>
                    {{-- Header dengan Icon Orange (Lock) --}}
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                            <x-admin.icon.lock class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Security</h3>
                            <p class="text-xs text-gray-500">Leave password fields blank if you don't want to change it.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-admin.form.group label="New Password" name="password">
                            <x-admin.form.input type="password" name="password" autocomplete="new-password" placeholder="Min. 8 characters" />
                        </x-admin.form.group>

                        <x-admin.form.group label="Confirm New Password" name="password_confirmation">
                            <x-admin.form.input type="password" name="password_confirmation" placeholder="Re-type your new password" />
                        </x-admin.form.group>
                    </div>
                </div>

            </div>

            {{-- FOOTER CARD (Konsisten dengan form lain) --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end">
                <x-admin.ui.button type="submit">
                    Update Profile
                </x-admin.ui.button>
            </div>
            
        </div>
    </form>
</x-admin.layouts.app>