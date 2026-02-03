<x-admin.layouts.app title="Profile Settings">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Profile Settings' => '#',
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    My Profile
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8"> {{-- Wrapper utama --}}

        {{-- ========================================== --}}
        {{-- CARD 1: PROFILE INFORMATION & PASSWORD     --}}
        {{-- ========================================== --}}
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                
                <div class="p-6 space-y-8">
                    
                    {{-- SECTION 1: BASIC INFORMATION --}}
                    <div>
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
                            {{-- Name --}}
                            <x-admin.form.group label="Full Name" name="name" required>
                                {{-- FIX: Pake auth('employee')->user() --}}
                                <x-admin.form.input name="name" :value="old('name', auth('employee')->user()->name)" required autofocus />
                            </x-admin.form.group>

                            {{-- Email --}}
                            <x-admin.form.group label="Email Address" name="email" required>
                                {{-- FIX: Pake auth('employee')->user() --}}
                                <x-admin.form.input type="email" name="email" :value="old('email', auth('employee')->user()->email)" required />
                            </x-admin.form.group>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    {{-- SECTION 2: CHANGE PASSWORD --}}
                    <div>
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

                {{-- FOOTER CARD --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end">
                    <x-admin.ui.button type="submit">
                        Update Profile
                    </x-admin.ui.button>
                </div>
                
            </div>
        </form>


        {{-- ========================================== --}}
        {{-- CARD 2: TWO FACTOR AUTHENTICATION          --}}
        {{-- ========================================== --}}
        @if(\App\Models\Setting::get('site_2fa_enabled'))
            
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                            <x-admin.icon.lock-closed class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Two-Factor Authentication</h3>
                            <p class="text-xs text-gray-500">Add additional security to your account using 2FA.</p>
                        </div>
                    </div>

                    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5">
                        
                        @if(! auth('employee')->user()->two_factor_secret)
                            {{-- STATE 1: BELUM AKTIF --}}
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <h4 class="font-bold text-indigo-900">You have not enabled 2FA yet.</h4>
                                    <p class="text-xs text-indigo-700 mt-1 max-w-lg">
                                        When enabled, you will be prompted for a secure token during authentication.
                                    </p>
                                </div>
                                
                                {{-- FIX ROUTE: admin.two-factor.enable --}}
                                <form method="POST" action="{{ route('admin.two-factor.enable') }}">
                                    @csrf
                                    <x-admin.ui.button type="submit" color="primary">
                                        Enable 2FA
                                    </x-admin.ui.button>
                                </form>
                            </div>

                        @else
                            {{-- STATE 2: SUDAH AKTIF --}}
                            <div class="space-y-6">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <h4 class="font-bold text-green-700 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            2FA is Enabled
                                        </h4>
                                        <p class="text-xs text-indigo-700 mt-1">
                                            Scan the QR code below using your authenticator app.
                                        </p>
                                    </div>
                                    
                                    {{-- FIX ROUTE: admin.two-factor.disable --}}
                                    <form method="POST" action="{{ route('admin.two-factor.disable') }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.ui.button type="submit" color="danger" onclick="return confirm('Disable 2FA?');">
                                            Disable 2FA
                                        </x-admin.ui.button>
                                    </form>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-indigo-200/50 pt-6">
                                    
                                    {{-- KOLOM KIRI: QR CODE & CONFIRMATION --}}
                                    <div>
                                        @if(session('status') == 'two-factor-authentication-enabled')
                                            {{-- TAMPILAN SAAT BARU KLIK ENABLE (BELUM CONFIRM) --}}
                                            <div class="mb-4">
                                                <div class="p-4 bg-white rounded-lg border border-gray-200 inline-block mb-4">
                                                    <p class="text-xs font-bold text-center text-gray-500 mb-2 uppercase tracking-wider">Scan this QR Code</p>
                                                    {!! auth('employee')->user()->twoFactorQrCodeSvg() !!}
                                                </div>
                                                
                                                <div class="space-y-3">
                                                    <p class="text-sm font-bold text-indigo-700">Finish configuring 2FA:</p>
                                                    <p class="text-xs text-gray-600">Enter the 6-digit code from your authenticator app to confirm and activate 2FA.</p>
                                                    
                                                    {{-- FORM CONFIRMATION (INI YANG KURANG TADI) 🔥 --}}
                                                    <form method="POST" action="{{ route('admin.two-factor.confirmed') }}">
                                                        @csrf
                                                        <div class="flex gap-2">
                                                            <x-admin.form.input name="code" placeholder="123456" class="w-32 text-center font-mono tracking-widest" required />
                                                            <x-admin.ui.button type="submit" color="primary" size="sm">
                                                                Activate
                                                            </x-admin.ui.button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        @elseif(auth('employee')->user()->two_factor_confirmed_at)
                                            {{-- TAMPILAN KALAU SUDAH CONFIRMED/AKTIF SEPENUHNYA --}}
                                            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                                <div class="flex items-center gap-3">
                                                    <div class="p-2 bg-green-100 text-green-600 rounded-full">
                                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-bold text-green-800">2FA is Active</h4>
                                                        <p class="text-xs text-green-700">Your account is secured. You will be asked for a code when logging in.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{-- KASUS LANGKA: Secret ada, tapi belum confirmed dan session flash hilang --}}
                                            <div class="bg-yellow-50 p-4 rounded border border-yellow-200">
                                                <p class="text-xs text-yellow-800 font-bold">2FA Setup Not Complete</p>
                                                <p class="text-xs text-yellow-700 mb-3">You enabled 2FA but didn't confirm the code. Please disable and enable it again to restart setup.</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- KOLOM KANAN: RECOVERY CODES --}}
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 mb-1">Recovery Codes</p>
                                        <p class="text-xs text-indigo-700/80 mb-3 leading-relaxed">
                                            Store these codes in a secure password manager. They can be used to recover access to your account if your 2FA device is lost.
                                        </p>
                                        
                                        {{-- LOGIC: Cuma tampilkan kode kalau baru Enable atau baru Regenerate --}}
                                        @if(session('status') == 'two-factor-authentication-enabled' || session('status') == 'recovery-codes-generated')
                                            
                                            <div class="bg-gray-900 rounded-lg p-4 mb-3 animate-pulse-once"> {{-- Tambah efek dikit biar sadar --}}
                                                <div class="grid grid-cols-2 gap-2">
                                                    @foreach (json_decode(decrypt(auth('employee')->user()->two_factor_recovery_codes), true) as $code)
                                                        <div class="text-xs font-mono text-green-400 tracking-wider select-all cursor-pointer hover:text-white">
                                                            • {{ $code }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4 text-xs text-red-500 font-bold">
                                                ⚠️ Copy these codes now. They will not be shown again.
                                            </div>

                                        @else
                                            {{-- TAMPILAN DEFAULT (HIDDEN) --}}
                                            <div class="bg-gray-100 rounded-lg p-4 mb-3 border border-gray-200 text-center">
                                                <p class="text-xs text-gray-500 italic">
                                                    Recovery codes are hidden for security.
                                                </p>
                                            </div>
                                        @endif
                                        
                                        {{-- FORM REGENERATE (Selalu Ada) --}}
                                        <form method="POST" action="{{ route('admin.two-factor.recovery-codes') }}">
                                            @csrf
                                            {{-- Kita bungkus button biar agak serius --}}
                                            <x-admin.ui.button type="submit" color="secondary" size="sm" onclick="return confirm('Generate new recovery codes? Old codes will stop working.');">
                                                Regenerate Recovery Codes
                                            </x-admin.ui.button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endif

    </div> 
</x-admin.layouts.app>