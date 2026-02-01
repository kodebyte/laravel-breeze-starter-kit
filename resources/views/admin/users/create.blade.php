<x-admin.layouts.app title="Add New User">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Users' => route('admin.users.index'), 
                    'Create New' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Add New User
                </h2>
            </div>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        {{-- CUKUP 1 CARD UTAMA --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8"> {{-- space-y-8 buat jarak antar section --}}
                
                {{-- SECTION 1: ACCOUNT --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <x-admin.icon.user-circle class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Account Information</h3>
                            <p class="text-xs text-gray-500">Basic details for the new user account.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5"> {{-- Gap 5 biar napas dikit --}}
                        <x-admin.form.group label="Full Name" name="name" required>
                            <x-admin.form.input name="name" :value="old('name')" required autofocus placeholder="Ex: John Doe" />
                        </x-admin.form.group>

                        <x-admin.form.group label="Email Address" name="email" required>
                            <x-admin.form.input type="email" name="email" :value="old('email')" required placeholder="Ex: john@client.com" />
                        </x-admin.form.group>
                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION (Garis Halus) --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: SECURITY --}}
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                            <x-admin.icon.lock class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Security Access</h3>
                            <p class="text-xs text-gray-500">Set the secure password for logging in.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-admin.form.group label="Password" name="password" required>
                            <x-admin.form.input type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters" />
                        </x-admin.form.group>

                        <x-admin.form.group label="Confirm Password" name="password_confirmation" required>
                            <x-admin.form.input type="password" name="password_confirmation" required placeholder="Re-type password" />
                        </x-admin.form.group>
                    </div>
                </div>

            </div>

            {{-- FOOTER CARD (Background beda dikit biar tegas) --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <x-admin.ui.button type="submit">
                    Create User
                </x-admin.ui.button>
            </div>
            
        </div>
    </form>
</x-admin.layouts.app>