<x-admin.layouts.guest>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    {{-- 🔥 UBAH ACTION JADI: admin.password.confirm 🔥 --}}
    <form method="POST" action="{{ route('admin.password.confirm') }}">
        @csrf

        <div class="mt-4">
            <x-admin.form.group label="Password" name="password">
                <x-admin.form.input id="password" class="block w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" autofocus />
            </x-admin.form.group>
        </div>

        <div class="flex justify-end mt-4">
            <x-admin.ui.button type="submit" color="primary">
                {{ __('Confirm') }}
            </x-admin.ui.button>
        </div>
    </form>
</x-admin.layouts.guest>