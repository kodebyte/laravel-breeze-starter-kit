<x-admin.layouts.guest>
    
    <div class="mb-8 text-center">
        <h2 class="text-xl font-bold text-gray-900">Sign in to Dashboard</h2>
        <p class="text-sm text-gray-500 mt-1">Enter your details to proceed</p>
    </div>

    <x-admin.ui.auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-6">
        @csrf

        <x-admin.form.group label="Email Address" name="email" required>
            <x-admin.form.input 
                id="email" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                placeholder="admin@kodebyte.com"
            />
        </x-admin.form.group>

        <x-admin.form.group label="Password" name="password" required>
            <x-admin.form.input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password" 
                placeholder="••••••••"
            />
        </x-admin.form.group>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-admin.form.checkbox id="remember_me" name="remember" />
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors" href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            @endif
        </div>

        <div>
            <x-admin.ui.button class="w-full justify-center py-3 text-sm shadow-md hover:shadow-lg transition-shadow">
                Log in
            </x-admin.ui.button>
        </div>
    </form>
</x-admin.layouts.guest>