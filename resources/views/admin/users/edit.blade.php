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

    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <x-admin.form.group label="Full Name" name="name" required>
                    <x-admin.form.input name="name" :value="old('name', $user->name)" required />
                </x-admin.form.group>

                <x-admin.form.group label="Email Address" name="email" required>
                    <x-admin.form.input type="email" name="email" :value="old('email', $user->email)" required />
                </x-admin.form.group>

                <div class="md:col-span-2 border-t border-gray-100 my-2"></div>

                <div class="md:col-span-2 mb-2">
                    <h3 class="text-sm font-bold text-gray-900">Security</h3>
                    <p class="text-xs text-gray-500">Leave blank to keep current password.</p>
                </div>

                <x-admin.form.group label="New Password" name="password">
                    <x-admin.form.input type="password" name="password" autocomplete="new-password" placeholder="Min. 8 characters" />
                </x-admin.form.group>

                <x-admin.form.group label="Confirm New Password" name="password_confirmation">
                    <x-admin.form.input type="password" name="password_confirmation" placeholder="Re-type new password" />
                </x-admin.form.group>

            </div>

            <div class="flex items-center justify-end gap-4 mt-8 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <x-admin.ui.button>
                    Update User
                </x-admin.ui.button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>