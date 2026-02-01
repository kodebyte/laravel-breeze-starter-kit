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

    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <x-admin.form.group label="Full Name" name="name" required>
                    <x-admin.form.input 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        placeholder="Ex: John Doe" 
                    />
                </x-admin.form.group>

                <x-admin.form.group label="Email Address" name="email" required>
                    <x-admin.form.input 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        placeholder="Ex: john@client.com" 
                    />
                </x-admin.form.group>

                <div class="md:col-span-2 border-t border-gray-100 my-2"></div>

                <div class="md:col-span-2 mb-2">
                    <h3 class="text-sm font-bold text-gray-900">Security</h3>
                    <p class="text-xs text-gray-500">Set the initial password for this user.</p>
                </div>

                <x-admin.form.group label="Password" name="password" required>
                    <x-admin.form.input 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Min. 8 characters"
                    />
                </x-admin.form.group>

                <x-admin.form.group label="Confirm Password" name="password_confirmation" required>
                    <x-admin.form.input 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        placeholder="Re-type password"
                    />
                </x-admin.form.group>

            </div>

            <div class="flex items-center justify-end gap-4 mt-8 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <x-admin.ui.button>
                    Create User
                </x-admin.ui.button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>