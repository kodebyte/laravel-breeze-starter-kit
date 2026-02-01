<x-admin.layouts.app title="Profile Settings">
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="['Profile Settings' => '#']" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            My Profile
        </h2>
    </x-slot>

    <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('PUT')

            {{-- Ganti Grid jadi Stacked (Satu Kolom) --}}
            <div class="space-y-12">
                
                {{-- SECTION 1: Informasi Dasar --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-50 pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Basic Information</h3>
                        <p class="text-xs text-gray-400">Update your account's profile information and email address.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-admin.form.group label="Full Name" name="name" required>
                            <x-admin.form.input name="name" :value="old('name', $employee->name)" required />
                        </x-admin.form.group>

                        <x-admin.form.group label="Email Address" name="email" required>
                            <x-admin.form.input type="email" name="email" :value="old('email', $employee->email)" required />
                        </x-admin.form.group>
                    </div>
                </div>

                {{-- SECTION 2: Keamanan (Password) --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-50 pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Security</h3>
                        <p class="text-xs text-gray-500 italic">Leave password fields blank if you don't want to change it.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-admin.form.group label="New Password" name="password">
                            <x-admin.form.input type="password" name="password" autocomplete="new-password" placeholder="Min. 8 characters" />
                        </x-admin.form.group>

                        <x-admin.form.group label="Confirm New Password" name="password_confirmation">
                            <x-admin.form.input type="password" name="password_confirmation" placeholder="Re-type your new password" />
                        </x-admin.form.group>
                    </div>
                </div>

            </div>

            <div class="mt-12 pt-6 border-t border-gray-100 flex justify-end">
                <x-admin.ui.button>Update Profile</x-admin.ui.button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>