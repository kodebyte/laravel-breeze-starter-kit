<div x-data="{ searchMenu: '' }" class="w-64 bg-white border-r border-gray-100 min-h-screen flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-10">
    
    {{-- 1. HEADER: Logo & Notification Bell --}}
    <div class="h-16 flex items-center justify-between px-5 border-b border-gray-100">
        {{-- LOGO (Sisi Kiri) --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
            <div class="bg-gray-900 text-white p-1 rounded group-hover:bg-primary transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="text-lg font-bold tracking-tight text-gray-900">
                Master<span class="text-primary">Kit</span>
            </span>
        </a>

        {{-- NOTIFICATION BELL (Sisi Kanan) --}}
        <div class="relative" x-data="{ openNotif: false }">
            <button @click="openNotif = !openNotif" class="relative p-1.5 text-gray-400 hover:text-primary transition-colors focus:outline-none">
                <x-admin.icon.bell class="w-5 h-5" />
                
                @if(Auth::guard('employee')->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1 right-1 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500 border border-white"></span>
                    </span>
                @endif
            </button>

            {{-- Dropdown Panel: Ganti ke left-0 biar muncul ke arah kanan (konten utama) --}}
            <div x-show="openNotif" 
                x-cloak
                @click.outside="openNotif = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute left-0 mt-3 w-72 bg-white rounded-xl shadow-xl py-1 border border-gray-100 z-50">
                
                <div class="px-4 py-2 border-b border-gray-50 flex justify-between items-center">
                    <span class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Recent Notifications</span>
                    <a href="{{ route('admin.notifications.index') }}" class="text-[10px] text-primary font-bold hover:underline">View All</a>
                </div>

                <div class="max-h-64 overflow-y-auto">
                    @forelse(Auth::guard('employee')->user()->unreadNotifications->take(5) as $notification)
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition-colors">
                            <p class="text-[11px] font-bold text-gray-900">{{ $notification->data['title'] }}</p>
                            <p class="text-[10px] text-gray-500 line-clamp-1">{{ $notification->data['message'] }}</p>
                            <p class="text-[9px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <p class="text-xs text-gray-400 italic">No updates available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 pb-2">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-admin.icon.search class="h-4 w-4 text-gray-400" />
            </div>
            <input type="text" 
                   x-model="searchMenu"
                   class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-gray-900 focus:border-gray-900 sm:text-sm transition duration-150 ease-in-out" 
                   placeholder="Search menu...">
        </div>
    </div>

    <nav class="flex-1 px-3 space-y-1 overflow-y-auto mt-2">
        
        @can('dashboard.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.dashboard')" 
                :active="request()->routeIs('admin.dashboard')" 
                title="Dashboard"
                x-show="'dashboard'.includes(searchMenu.toLowerCase())">
                <x-admin.icon.dashboard class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        <div class="pt-6 mb-2 px-3 text-xs font-bold text-gray-400 uppercase tracking-wider"
            x-show="'users employees staff'.includes(searchMenu.toLowerCase())">
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
                x-show="'employees staff internal'.includes(searchMenu.toLowerCase())">
                {{-- Kita pake icon briefcase atau identification buat bedain sama User --}}
                <x-admin.icon.briefcase class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        @can('roles.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.roles.index')" 
                :active="request()->routeIs('admin.roles.*')" 
                title="Roles & Access"
                x-show="'roles permissions access'.includes(searchMenu.toLowerCase())">
                {{-- Pake icon Shield biar kelihatan secure --}}
                <x-admin.icon.shield class="w-5 h-5" />
            </x-admin.layouts.sidebar-link>
        @endcan

        <div class="pt-6 mb-2 px-3 text-xs font-bold text-gray-400 uppercase tracking-wider"
            x-show="'user profile'.includes(searchMenu.toLowerCase())">
            Account
        </div>

        <x-admin.layouts.sidebar-link 
            :href="route('admin.profile.edit')" 
            :active="request()->routeIs('admin.profile.*')" 
            title="Profile Settings"
            x-show="'profile settings account password me'.includes(searchMenu.toLowerCase())">
            <x-admin.icon.user-circle class="w-5 h-5" />
        </x-admin.layouts.sidebar-link>

        <div class="pt-6 mb-2 px-3 text-xs font-bold text-gray-400 uppercase tracking-wider"
            x-show="'activity logs system history audit'.includes(searchMenu.toLowerCase())">
            System
        </div>

        @can('logs.view')
            <x-admin.layouts.sidebar-link 
                :href="route('admin.logs.index')" 
                :active="request()->routeIs('admin.logs.*')" 
                title="Activity Logs"
                x-show="'activity logs system history audit'.includes(searchMenu.toLowerCase())">
                
                {{-- Icon: Menggunakan komponen icon yang sudah kita pecah --}}
                <x-admin.icon.clock-rewind class="w-5 h-5" />

            </x-admin.layouts.sidebar-link>
        @endcan

        <div x-show="searchMenu !== '' && 
                    !'dashboard'.includes(searchMenu.toLowerCase()) && 
                    !'users clients customers'.includes(searchMenu.toLowerCase()) && 
                    !'employees staff internal'.includes(searchMenu.toLowerCase()) &&
                    !'roles permissions access'.includes(searchMenu.toLowerCase()) &&
                    !'user profile settings account password me'.includes(searchMenu.toLowerCase()) &&
                    !'activity logs system history audit'.includes(searchMenu.toLowerCase())
                    "
             class="px-3 py-10 text-center text-xs text-gray-400 italic">
            Menu not found...
        </div>

    </nav>
    
    <div class="border-t border-gray-100 p-4 bg-gray-50/50">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm border border-gray-300">
                {{ substr(Auth::guard('employee')->user()->name ?? 'A', 0, 1) }}
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">
                    {{ Auth::guard('employee')->user()->name ?? 'Admin' }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                    {{ Auth::guard('employee')->user()->roles->first()->name ?? 'Staff' }}
                </p>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors p-1">
                    <x-admin.icon.logout class="w-5 h-5" />
                </button>
            </form>
        </div>
    </div>
</div>