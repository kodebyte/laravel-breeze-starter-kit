<x-admin.layouts.app title="General Settings">
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="[
            'System' => '#', 
            'General Settings' => '#'
        ]" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            General Settings
        </h2>
    </x-slot>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- SINGLE CARD LAYOUT --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            
            <div class="p-6 space-y-8">
                
                {{-- SECTION 1: SITE IDENTITY --}}
                <div>
                    {{-- Header Icon Biru (Identity) --}}
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-blue-50 text-primary rounded-lg">
                            <x-admin.icon.globe class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Site Identity</h3>
                            <p class="text-xs text-gray-500">Manage your website's public identity and branding.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <x-admin.form.group label="Site Name" name="site_name" required>
                            <x-admin.form.input name="site_name" :value="\App\Models\Setting::get('site_name', 'Kodebyte')" required />
                        </x-admin.form.group>

                        <x-admin.form.group label="Tagline" name="site_tagline">
                            <x-admin.form.input name="site_tagline" :value="\App\Models\Setting::get('site_tagline')" />
                        </x-admin.form.group>
                        
                        <div class="md:col-span-2">
                            <x-admin.form.group label="Logo (Light Mode)" name="logo_light">
                                <input type="file" name="logo_light" 
                                    class="block w-full text-sm text-gray-500 
                                    file:mr-4 file:py-2 file:px-4 
                                    file:rounded-lg file:border-0 
                                    file:text-xs file:font-bold 
                                    file:bg-gray-50 file:text-gray-700 
                                    hover:file:bg-gray-100 
                                    cursor-pointer border border-gray-200 rounded-lg p-1">
                            </x-admin.form.group>
                        </div>
                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 2: CONTACT INFORMATION --}}
                <div>
                    {{-- Header Icon Hijau/Teal (Contact) --}}
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-teal-50 text-teal-600 rounded-lg">
                            <x-admin.icon.phone class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Contact Information</h3>
                            <p class="text-xs text-gray-500">Public contact details displayed in footer.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <x-admin.form.group label="Official Email" name="office_email" required>
                            <x-admin.form.input type="email" name="office_email" :value="\App\Models\Setting::get('office_email', 'hello@kodebyte.id')" required />
                        </x-admin.form.group>

                        <x-admin.form.group label="Phone Number" name="office_phone">
                            <x-admin.form.input name="office_phone" :value="\App\Models\Setting::get('office_phone')" />
                        </x-admin.form.group>

                        <div class="md:col-span-2">
                            <x-admin.form.group label="Office Address" name="office_address">
                                <x-admin.form.textarea name="office_address" rows="3">{{ \App\Models\Setting::get('office_address') }}</x-admin.form.textarea>
                            </x-admin.form.group>
                        </div>
                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 3: SOCIAL MEDIA --}}
                <div>
                    {{-- Header Icon Ungu (Social) --}}
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            <x-admin.icon.share class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Social Media</h3>
                            <p class="text-xs text-gray-500">Connect your audience with your social platforms.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <x-admin.form.group label="Instagram URL" name="social_instagram">
                            <x-admin.form.input name="social_instagram" :value="\App\Models\Setting::get('social_instagram')" placeholder="https://instagram.com/..." />
                        </x-admin.form.group>

                        <x-admin.form.group label="TikTok URL" name="social_tiktok">
                            <x-admin.form.input name="social_tiktok" :value="\App\Models\Setting::get('social_tiktok')" placeholder="https://tiktok.com/@..." />
                        </x-admin.form.group>
                    </div>
                </div>

                {{-- PEMISAH ANTAR SECTION --}}
                <div class="border-t border-gray-100"></div>

                {{-- SECTION 4: MAINTENANCE MODE --}}
                <div>
                    {{-- Header Icon Merah (Danger Zone) --}}
                    <div class="flex items-center gap-2 mb-6">
                        <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                            <x-admin.icon.cone class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">System Status</h3>
                            <p class="text-xs text-gray-500">Control public access to your application.</p>
                        </div>
                    </div>

                    {{-- Maintenance Alert Box --}}
                    <div class="bg-red-50/50 border border-red-100 rounded-xl p-5 flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-bold text-red-900">Maintenance Mode</h4>
                            <p class="text-xs text-red-600/80 mt-1">
                                When active, only administrators can access the site. <br>
                                Visitors will see a "Service Unavailable" page.
                            </p>
                        </div>

                        {{-- Toggle Switch --}}
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="maintenance_mode" value="0">
                            <input type="checkbox" name="maintenance_mode" value="1" 
                                class="sr-only peer"
                                {{ \App\Models\Setting::get('maintenance_mode') ? 'checked' : '' }}>
                            
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                        </label>
                    </div>
                </div>

            </div>

            {{-- FOOTER CARD --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end">
                <x-admin.ui.button type="submit" color="primary">
                    Save Changes
                </x-admin.ui.button>
            </div>
            
        </div>
    </form>
</x-admin.layouts.app>