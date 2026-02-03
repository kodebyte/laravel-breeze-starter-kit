<x-admin.layouts.app title="Global Settings">
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="[
            'System' => '#', 
            'Global Settings' => '#'
        ]" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            Global Settings
        </h2>
    </x-slot>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- LAYOUT WRAPPER (ALPINE JS) --}}
        <div x-data="{ activeTab: 'general' }" class="flex flex-col lg:flex-row gap-6 items-start relative">

            {{-- === [KIRI] SIDEBAR NAVIGATION === --}}
            <div class="w-full lg:w-64 shrink-0 space-y-1 lg:sticky lg:top-4">
                
                {{-- Tab: General --}}
                <button type="button" @click="activeTab = 'general'"
                    :class="activeTab === 'general' ? 'bg-white text-primary shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center gap-3">
                    <x-admin.icon.globe class="w-5 h-5" /> General Identity
                </button>

                {{-- Tab: Contact --}}
                <button type="button" @click="activeTab = 'contact'"
                    :class="activeTab === 'contact' ? 'bg-white text-primary shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center gap-3">
                    <x-admin.icon.phone class="w-5 h-5" /> Contact Info
                </button>

                {{-- Tab: Social --}}
                <button type="button" @click="activeTab = 'social'"
                    :class="activeTab === 'social' ? 'bg-white text-primary shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center gap-3">
                    <x-admin.icon.share class="w-5 h-5" /> Social Media
                </button>
                
                {{-- Tab: Scripts --}}
                <button type="button" @click="activeTab = 'scripts'"
                    :class="activeTab === 'scripts' ? 'bg-white text-primary shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center gap-3">
                    <x-admin.icon.code class="w-5 h-5" /> Analytics & Scripts
                </button>

                {{-- Tab: Security --}}
                <button type="button" @click="activeTab = 'security'"
                    :class="activeTab === 'security' ? 'bg-white text-primary shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center gap-3">
                    <x-admin.icon.lock-closed class="w-5 h-5" /> Security & Access
                </button>

                {{-- Tab: Backup --}}
                <button type="button" @click="activeTab = 'backup'"
                    :class="activeTab === 'backup' ? 'bg-white text-primary shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center gap-3">
                    <x-admin.icon.cloud-upload class="w-5 h-5" /> Backup & Storage
                </button>
            </div>

            {{-- === [KANAN] CONTENT AREA === --}}
            <div class="flex-1 w-full bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                
                <div class="p-6">
                    
                    {{-- 1. TAB: GENERAL IDENTITY --}}
                    <div x-show="activeTab === 'general'" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">
                         
                        {{-- Header Style (Consistent with Create User) --}}
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-blue-50 text-primary rounded-lg">
                                <x-admin.icon.globe class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Site Identity</h3>
                                <p class="text-xs text-gray-500">Manage your website's public identity.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <x-admin.form.group label="Site Name" name="site_name" required>
                                <x-admin.form.input name="site_name" :value="\App\Models\Setting::get('site_name', 'Kodebyte')" required />
                            </x-admin.form.group>

                            <x-admin.form.group label="Tagline" name="site_tagline">
                                <x-admin.form.input name="site_tagline" :value="\App\Models\Setting::get('site_tagline')" />
                            </x-admin.form.group>
                            
                            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <x-admin.form.group label="Logo (Light Mode)" name="logo_light">
                                    @if($logo = \App\Models\Setting::get('logo_light'))
                                        <div class="mb-3 bg-white p-2 w-fit rounded border border-gray-200">
                                            <img src="{{ asset('storage/'.$logo) }}" class="h-10 w-auto">
                                        </div>
                                    @endif
                                    <input type="file" name="logo_light" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-white file:text-primary hover:file:bg-gray-100 cursor-pointer border border-gray-200 rounded-lg p-1">
                                </x-admin.form.group>
                            </div>
                        </div>
                    </div>

                    {{-- 2. TAB: CONTACT INFO --}}
                    <div x-show="activeTab === 'contact'" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">
                         
                        {{-- Header Style --}}
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-teal-50 text-teal-600 rounded-lg">
                                <x-admin.icon.phone class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Contact Information</h3>
                                <p class="text-xs text-gray-500">Public contact details displayed in footer.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <x-admin.form.group label="Official Email" name="office_email" required>
                                <x-admin.form.input type="email" name="office_email" :value="\App\Models\Setting::get('office_email')" required />
                            </x-admin.form.group>

                            <x-admin.form.group label="Phone / WhatsApp" name="office_phone">
                                <x-admin.form.input name="office_phone" :value="\App\Models\Setting::get('office_phone')" placeholder="+62..." />
                            </x-admin.form.group>

                            <div class="md:col-span-2">
                                <x-admin.form.group label="Office Address" name="office_address">
                                    <x-admin.form.textarea name="office_address" rows="3">{{ \App\Models\Setting::get('office_address') }}</x-admin.form.textarea>
                                </x-admin.form.group>
                            </div>
                            
                            <div class="md:col-span-2">
                                <x-admin.form.group label="Google Maps Embed (Iframe URL Only)" name="map_embed">
                                    <x-admin.form.input name="map_embed" :value="\App\Models\Setting::get('map_embed')" placeholder="https://www.google.com/maps/embed?..." />
                                </x-admin.form.group>
                            </div>
                        </div>
                    </div>

                    {{-- 3. TAB: SOCIAL MEDIA --}}
                    <div x-show="activeTab === 'social'" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">
                         
                        {{-- Header Style --}}
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                                <x-admin.icon.share class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Social Media</h3>
                                <p class="text-xs text-gray-500">Connect with your community.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5">
                            <x-admin.form.group label="Instagram" name="social_instagram" inline>
                                <x-admin.form.input name="social_instagram" :value="\App\Models\Setting::get('social_instagram')" placeholder="https://instagram.com/..." />
                            </x-admin.form.group>

                            <x-admin.form.group label="TikTok" name="social_tiktok" inline>
                                <x-admin.form.input name="social_tiktok" :value="\App\Models\Setting::get('social_tiktok')" placeholder="https://tiktok.com/@..." />
                            </x-admin.form.group>
                            
                            <x-admin.form.group label="YouTube" name="social_youtube" inline>
                                <x-admin.form.input name="social_youtube" :value="\App\Models\Setting::get('social_youtube')" placeholder="https://youtube.com/..." />
                            </x-admin.form.group>
                            
                            <x-admin.form.group label="LinkedIn" name="social_linkedin" inline>
                                <x-admin.form.input name="social_linkedin" :value="\App\Models\Setting::get('social_linkedin')" placeholder="https://linkedin.com/in/..." />
                            </x-admin.form.group>
                        </div>
                    </div>

                    {{-- 4. TAB: SCRIPTS --}}
                    <div x-show="activeTab === 'scripts'" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">
                         
                        {{-- Header Style --}}
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-gray-100 text-gray-600 rounded-lg">
                                <x-admin.icon.code class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Custom Scripts</h3>
                                <p class="text-xs text-gray-500">Inject scripts for Analytics, Pixel, or Chat Widgets.</p>
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 text-yellow-800 p-3 rounded-lg text-xs flex gap-2 border border-yellow-200 mb-4">
                            <x-admin.icon.info class="w-4 h-4 mt-0.5" />
                            <p><strong>Warning:</strong> Be careful when adding scripts here. Invalid HTML/JS can break your site layout.</p>
                        </div>

                        <x-admin.form.group label="Header Scripts (Inside <head>)" name="scripts_header">
                            <x-admin.form.textarea name="scripts_header" rows="6" class="font-mono text-xs" placeholder="">{{ \App\Models\Setting::get('scripts_header') }}</x-admin.form.textarea>
                        </x-admin.form.group>

                        <x-admin.form.group label="Footer Scripts (Before </body>)" name="scripts_footer">
                            <x-admin.form.textarea name="scripts_footer" rows="6" class="font-mono text-xs" placeholder="">{{ \App\Models\Setting::get('scripts_footer') }}</x-admin.form.textarea>
                        </x-admin.form.group>
                    </div>

                    {{-- 5. TAB: SECURITY --}}
                    <div x-show="activeTab === 'security'" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">
                         
                        {{-- Header Style --}}
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                                <x-admin.icon.lock-closed class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Security & Access</h3>
                                <p class="text-xs text-gray-500">System maintenance and authentication policies.</p>
                            </div>
                        </div>

                        {{-- Maintenance Mode --}}
                        <div class="bg-red-50/50 border border-red-100 rounded-xl p-5 flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-red-900">Maintenance Mode</h4>
                                <p class="text-xs text-red-600/80 mt-1">Visitors will see a "Service Unavailable" page.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="maintenance_mode" value="0">
                                <input type="checkbox" name="maintenance_mode" value="1" 
                                    class="sr-only peer" {{ \App\Models\Setting::get('maintenance_mode') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                            </label>
                        </div>

                        {{-- 2FA Mode --}}
                        <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-5 flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold text-indigo-900">Two-Factor Authentication (2FA)</h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-700">OPTIONAL</span>
                                </div>
                                <p class="text-xs text-indigo-600/80 mt-1">
                                    Allow users to enable 2FA on their accounts for extra security.
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="site_2fa_enabled" value="0">
                                <input type="checkbox" name="site_2fa_enabled" value="1" 
                                    class="sr-only peer" {{ \App\Models\Setting::get('site_2fa_enabled') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>

                    {{-- 6. TAB: BACKUP (GOOGLE DRIVE) --}}
                    <div x-show="activeTab === 'backup'" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">
                         
                        {{-- Header Style --}}
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                <x-admin.icon.cloud-upload class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Backup & Storage</h3>
                                <p class="text-xs text-gray-500">Google Drive integration & automation.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 mb-6">
                            <div>
                                <label class="font-bold text-gray-900 text-sm">Enable Daily Automated Backup</label>
                                <p class="text-xs text-gray-500">System will run backup every day at 00:00.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="backup_daily_active" value="0">
                                <input type="checkbox" name="backup_daily_active" value="1" 
                                    class="sr-only peer" {{ \App\Models\Setting::get('backup_daily_active') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                             <h4 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/1/12/Google_Drive_icon_%282020%29.svg" class="w-4 h-4">
                                Google Drive Configuration
                            </h4>

                            <div class="grid grid-cols-1 gap-4">
                                <x-admin.form.group label="Client ID" name="backup_google_client_id">
                                    <x-admin.form.input name="backup_google_client_id" :value="\App\Models\Setting::get('backup_google_client_id')" class="font-mono text-xs" />
                                </x-admin.form.group>
                                <x-admin.form.group label="Client Secret" name="backup_google_client_secret">
                                    <x-admin.form.input type="password" name="backup_google_client_secret" :value="\App\Models\Setting::get('backup_google_client_secret')" />
                                </x-admin.form.group>
                                <x-admin.form.group label="Refresh Token" name="backup_google_refresh_token">
                                    <x-admin.form.input type="password" name="backup_google_refresh_token" :value="\App\Models\Setting::get('backup_google_refresh_token')" />
                                </x-admin.form.group>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- GLOBAL SAVE BUTTON --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                    <p class="text-xs text-gray-400 hidden lg:block">Changes are applied immediately after saving.</p>
                    <x-admin.ui.button type="submit" color="primary">
                        Save All Settings
                    </x-admin.ui.button>
                </div>

            </div>

        </div>
    </form>
</x-admin.layouts.app>