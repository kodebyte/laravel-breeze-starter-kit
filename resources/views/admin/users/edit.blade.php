<x-admin.layouts.app title="Edit User">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Users' => route('admin.users.index'), 
                    'Edit User' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Edit User: <span class="text-primary">{{ $user->name }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        {{-- SINGLE CARD LAYOUT --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8">
                
                {{-- SECTION 1: ACCOUNT --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <x-admin.icon.user-circle class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Account Information</h3>
                            <p class="text-xs text-gray-500">Update basic account details.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-admin.form.group label="Full Name" name="name" required>
                            <x-admin.form.input name="name" :value="old('name', $user->name)" required />
                        </x-admin.form.group>

                        <x-admin.form.group label="Email Address" name="email" required>
                            <x-admin.form.input type="email" name="email" :value="old('email', $user->email)" required />
                        </x-admin.form.group>
                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: SECURITY --}}
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-admin.form.group label="New Password" name="password">
                            <x-admin.form.input type="password" name="password" autocomplete="new-password" placeholder="Min. 8 characters" />
                        </x-admin.form.group>

                        <x-admin.form.group label="Confirm New Password" name="password_confirmation">
                            <x-admin.form.input type="password" name="password_confirmation" placeholder="Re-type new password" />
                        </x-admin.form.group>
                    </div>
                </div>

            </div>

            {{-- FOOTER CARD --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <x-admin.ui.button type="submit">
                    Update User
                </x-admin.ui.button>
            </div>
            
        </div>
    </form>
</x-admin.layouts.app>