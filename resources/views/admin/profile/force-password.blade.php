<x-admin.layouts.guest>
    {{-- Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-xl font-bold text-gray-900">Security Notice</h2>
        <p class="text-sm text-gray-500 mt-1">To ensure your account's security, you are required to change your default password before proceeding</p>
    </div>

    {{-- Alert Section --}}
    <x-admin.ui.alert class="mb-6" />

    {{-- Form Section --}}
    <form method="POST" action="{{ route('admin.force-password-change.update') }}" class="space-y-6">
        @csrf

        <x-admin.form.group label="New Password" name="password" required>
            <x-admin.form.input 
                id="password" 
                type="password" 
                name="password" 
                required 
                placeholder="••••••••"
            />
        </x-admin.form.group>

        <x-admin.form.group label="Confirm New Password" name="password_confirmation" required>
            <x-admin.form.input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                required 
                placeholder="••••••••"
            />
        </x-admin.form.group>

        <div>
            <x-admin.ui.button class="w-full justify-center py-3 text-sm shadow-md hover:shadow-lg transition-shadow">
                Update Password <x-admin.icon.arrow-right class="w-4 h-4 ml-2" />
            </x-admin.ui.button>
        </div>
    </form>

    {{-- Footer Actions --}}
    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="text-sm font-semibold text-gray-400 hover:text-red-500 transition-colors">
                Cancel and Sign Out
            </button>
        </form>
    </div>
</x-admin.layouts.guest>