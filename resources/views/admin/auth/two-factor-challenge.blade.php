<x-admin.layouts.guest>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div x-data="{ recovery: false }">
            
            {{-- WRAPPER 1: AUTHENTICATION CODE (OTP) --}}
            {{-- Kita bungkus div karena x-show tidak bisa ditempel langsung di component group --}}
            <div x-show="!recovery">
                <x-admin.form.group label="Authentication Code" name="code">
                    <x-admin.form.input 
                        id="code" 
                        class="block w-full text-center tracking-[0.5em] font-mono font-bold text-xl" 
                        type="text" 
                        inputmode="numeric" 
                        name="code" 
                        autofocus 
                        x-ref="code" 
                        autocomplete="one-time-code" 
                    />
                </x-admin.form.group>
            </div>

            {{-- WRAPPER 2: RECOVERY CODE --}}
            <div x-show="recovery" style="display: none;">
                <x-admin.form.group label="Recovery Code" name="recovery_code">
                    <x-admin.form.input 
                        id="recovery_code" 
                        class="block w-full font-mono" 
                        type="text" 
                        name="recovery_code" 
                        x-ref="recovery_code" 
                        autocomplete="one-time-code" 
                    />
                </x-admin.form.group>
            </div>

            <div class="flex items-center justify-end mt-4 gap-4">
                {{-- TOMBOL SWITCH --}}
                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                        x-on:click="
                            recovery = ! recovery;
                            $nextTick(() => { recovery ? $refs.recovery_code.focus() : $refs.code.focus() })
                        ">
                    <span x-show="! recovery">Use a recovery code</span>
                    <span x-show="recovery" style="display: none;">Use an authentication code</span>
                </button>

                {{-- TOMBOL SUBMIT --}}
                <x-admin.ui.button type="submit" color="primary">
                    {{ __('Log in') }}
                </x-admin.ui.button>
            </div>
        </div>
    </form>
</x-admin.layouts.guest>