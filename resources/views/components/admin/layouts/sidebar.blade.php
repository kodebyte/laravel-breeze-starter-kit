<div x-data="{ searchMenu: '' }" class="w-64 bg-white border-r border-gray-100 min-h-screen flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-20">
    
    {{-- 1. HEADER: Logo & Notification Bell --}}
    <div class="h-16 flex items-center justify-between px-5 border-b border-gray-100">
        {{-- Logo Area --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
            <div class="bg-gray-900 text-white p-1 rounded group-hover:bg-primary transition-colors">
                @if(\App\Models\Setting::get('logo_light'))
                    <img src="{{ asset('storage/' . \App\Models\Setting::get('logo_light')) }}" class="w-5 h-5 object-contain" alt="Logo">
                @else
                    {{-- Default Logo Icon --}}
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                @endif
            </div>
            <span class="text-lg font-bold tracking-tight text-gray-900">
                {{ \App\Models\Setting::get('site_name', 'MasterKit') }}
            </span>
        </a>

        {{-- NOTIFICATION BELL (Panel Dropdown) --}}
        <div class="relative" x-data="{ openNotif: false }">
            <button @click="openNotif = !openNotif" class="relative p-1.5 text-gray-400 hover:text-primary transition-colors focus:outline-none">
                <x-admin.icon.bell class="w-5 h-5" />
                
                {{-- Badge Unread Count --}}
                @if(Auth::guard('employee')->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1 right-1 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500 border border-white"></span>
                    </span>
                @endif
            </button>

            {{-- Dropdown Panel (Arah Kanan/Left-0) --}}
            <div x-show="openNotif" 
                x-cloak
                @click.outside="openNotif = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute left-0 mt-3 w-72 bg-white rounded-xl shadow-xl py-1 border border-gray-100 z-50 origin-top-left">
                
                <div class="px-4 py-2 border-b border-gray-50 flex justify-between items-center bg-gray-50/50 rounded-t-xl">
                    <span class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Recent Notifications</span>
                    <a href="{{ route('admin.notifications.index') }}" class="text-[10px] text-primary font-bold hover:underline">View All</a>
                </div>

                <div class="max-h-64 overflow-y-auto">
                    @forelse(Auth::guard('employee')->user()->unreadNotifications->take(5) as $notification)
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition-colors group">
                            <div class="flex items-start gap-2">
                                <div class="mt-0.5">
                                    @if($notification->data['type'] == 'danger')
                                        <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div>
                                    @elseif($notification->data['type'] == 'warning')
                                        <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div>
                                    @else
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $notification->data['title'] }}</p>
                                    <p class="text-[10px] text-gray-500 line-clamp-1 mt-0.5">{{ $notification->data['message'] }}</p>
                                    <p class="text-[9px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center flex flex-col items-center">
                            <x-admin.icon.bell class="w-6 h-6 text-gray-200 mb-2" />
                            <p class="text-xs text-gray-400 italic">No new notifications</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- 2. SEARCH BAR --}}
    <div class="p-4 pb-2">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-admin.icon.search class="h-4 w-4 text-gray-400" />
            </div>
            <input type="text" 
                   x-model="searchMenu"
                   class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm transition duration-150 ease-in-out" 
                   placeholder="Search menu...">
        </div>
    </div>

    {{-- 3. MENU NAVIGATION --}}
    <nav class="flex-1 px-3 space-y-1 overflow-y-auto mt-2 scrollbar-hide">
        
        {{-- DASHBOARD --}}
        @can('dashboard.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.dashboard')" 
                :active="request()->routeIs('admin.dashboard')" 
                title="Dashboard"
                x-show="'dashboard home analytics stats'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.dashboard class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        {{-- GROUP: MANAGEMENT --}}
        <div class="pt-6 mb-2 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest"
            x-show="'users employees staff roles management'.includes(searchMenu.toLowerCase())">
            Management
        </div>

        @can('users.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.users.index')" 
                :active="request()->routeIs('admin.users.*')" 
                title="Users"
                x-show="'users clients customers'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.users class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        @can('employees.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.employees.index')" 
                :active="request()->routeIs('admin.employees.*')" 
                title="Employees"
                x-show="'employees staff internal team'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.briefcase class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        @can('roles.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.roles.index')" 
                :active="request()->routeIs('admin.roles.*')" 
                title="Roles & Access"
                x-show="'roles permissions access security'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.shield class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        {{-- GROUP: MANAGEMENT --}}
        <div class="pt-6 mb-2 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest"
            x-show="'users employees staff roles management'.includes(searchMenu.toLowerCase())">
             Content Management
        </div>

        {{-- 1. STATIC PAGES (YANG KITA BUAT SEKARANG) --}}
        @can('pages.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.pages.index')" 
                :active="request()->routeIs('admin.pages.*')" 
                title="Static Pages"
                x-show="'static pages seo about privacy terms'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.template class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        {{-- 2. MENU BUILDER (BARU) --}}
        @can('menus.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.menus.index')" 
                :active="request()->routeIs('admin.menus.*')" 
                title="Menu Manager"
                x-show="'menu navbar navigation builder link'.includes(searchMenu.toLowerCase())">
                {{-- Panggil icon menu yang baru dibuat --}}
                <x-admin.icon.menu class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        @can('inquiries.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.inquiries.index')" 
                :active="request()->routeIs('admin.inquiries.*')" 
                title="Inbox Messages"
                x-show="'inbox message contact inquiry'.includes(searchMenu.toLowerCase())">
                {{-- Icon Inbox --}}
                <x-admin.icon.envelop class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        {{-- GROUP: ACCOUNT --}}
        <div class="pt-6 mb-2 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest"
            x-show="'user profile account'.includes(searchMenu.toLowerCase())">
            Account
        </div>

        <x-admin.layouts.sidebar-link 
            :href="route('admin.profile.edit')" 
            :active="request()->routeIs('admin.profile.*')" 
            title="Profile Settings"
            x-show="'profile settings account password me'.includes(searchMenu.toLowerCase())">
            <x-admin.icon.user-circle class="w-5 h-5" />
        </x-admin.layouts.sidebar-link>

        {{-- GROUP: CONTENT & ASSETS --}}
        <div class="pt-6 mb-2 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest"
            x-show="'media files assets content library gallery upload'.includes(searchMenu.toLowerCase())">
            Content & Assets
        </div>

        @can('media.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.media.index')" 
                :active="request()->routeIs('admin.media.*')" 
                title="Media Library"
                x-show="'media files assets content library gallery upload'.includes(searchMenu.toLowerCase())">
                {{-- Icon Collection/Folder --}}
                <x-admin.icon.collection class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        {{-- GROUP: SYSTEM --}}
        <div class="pt-6 mb-2 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest"
            x-show="'activity logs system history audit settings general backups restore database health server status'.includes(searchMenu.toLowerCase())">
            System Administration
        </div>
        
        {{-- MENU: SYSTEM HEALTH (BARU) --}}
        @can('system.view_logs')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.system.index')" 
                :active="request()->routeIs('admin.system.*')" 
                title="System Health"
                x-show="'system health server status disk database cpu'.includes(searchMenu.toLowerCase())">
                {{-- Panggil icon yang baru kita buat --}}
                <x-admin.icon.chip class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        @can('logs.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.logs.index')" 
                :active="request()->routeIs('admin.logs.*')" 
                title="Activity Logs"
                x-show="'activity logs system history audit'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.activity class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        {{-- NEW: BACKUPS (Hanya Super Admin biasanya) --}}
        @if(auth()->user()->hasRole('Super Admin')) 
            <x-admin.layouts.sidebar-link 
                :href="route('admin.backups.index')" 
                :active="request()->routeIs('admin.backups.*')" 
                title="Backups & Restore"
                x-show="'backups restore database drive cloud'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.database class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endif

        @can('settings.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.settings.index')" 
                :active="request()->routeIs('admin.settings.*')" 
                title="General Settings"
                x-show="'settings general identity logo site config'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.cog class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        {{-- EMPTY STATE SEARCH --}}
        <div x-cloak x-show="searchMenu !== '' && 
                    !'dashboard'.includes(searchMenu.toLowerCase()) && 
                    !'users clients customers'.includes(searchMenu.toLowerCase()) && 
                    !'employees staff internal team'.includes(searchMenu.toLowerCase()) &&
                    !'roles permissions access security'.includes(searchMenu.toLowerCase()) &&
                    !'profile settings account password me'.includes(searchMenu.toLowerCase()) &&
                    !'activity logs system history audit'.includes(searchMenu.toLowerCase()) &&
                    !'backups restore database drive cloud'.includes(searchMenu.toLowerCase()) &&
                    !'settings general identity logo site config'.includes(searchMenu.toLowerCase())
                    "
             class="px-3 py-10 text-center flex flex-col items-center">
             <x-admin.icon.search class="w-6 h-6 text-gray-200 mb-2" />
             <p class="text-xs text-gray-400 italic">Menu not found</p>
        </div>

    </nav>
    
    {{-- 4. FOOTER: User Profile --}}
    <div class="border-t border-gray-100 p-4 bg-gray-50/50">
        <div class="flex items-center gap-3">
            {{-- Avatar Initials --}}
            <div class="h-9 w-9 rounded-full bg-white flex items-center justify-center text-gray-700 font-bold text-sm border border-gray-200 shadow-sm">
                {{ substr(Auth::guard('employee')->user()->name ?? 'A', 0, 1) }}
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-900 truncate">
                    {{ Auth::guard('employee')->user()->name ?? 'Admin' }}
                </p>
                <p class="text-[10px] text-gray-500 truncate uppercase tracking-wider">
                    {{ Auth::guard('employee')->user()->roles->first()->name ?? 'Staff' }}
                </p>
            </div>

            {{-- Logout Button --}}
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-lg transition-all" title="Sign Out">
                    <x-admin.icon.logout class="w-5 h-5" />
                </button>
            </form>
        </div>
    </div>
</div>