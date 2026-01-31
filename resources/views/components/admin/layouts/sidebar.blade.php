<div class="w-64 bg-white border-r border-gray-100 min-h-screen flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-10">
    
    <div class="h-16 flex items-center px-5 border-b border-gray-100">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <div class="bg-gray-900 text-white p-1 rounded">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <span class="text-lg font-bold tracking-tight text-gray-900">
                Kode<span class="text-primary">byte</span>
            </span>
        </a>
    </div>

    <div class="p-4 pb-2">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-admin.icon.search class="h-4 w-4 text-gray-400" />
            </div>
            <input type="text" 
                   class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-gray-900 focus:border-gray-900 sm:text-sm transition duration-150 ease-in-out" 
                   placeholder="Search menu...">
        </div>
    </div>

    <nav class="flex-1 px-3 space-y-1 overflow-y-auto mt-2">
        
        <x-admin.layouts.sidebar-link 
            :href="route('admin.dashboard')" 
            :active="request()->routeIs('admin.dashboard')" 
            title="Dashboard">
            
            <x-admin.icon.dashboard class="w-5 h-5" />
        </x-admin.layouts.sidebar-link>

        <div class="pt-6 mb-2 px-3 text-xs font-bold text-gray-400 uppercase tracking-wider">
            Management
        </div>

        <x-admin.layouts.sidebar-link 
            :href="route('admin.users.index')" 
            :active="request()->routeIs('admin.users.*')" 
            title="Users">
            
            <x-admin.icon.users class="w-5 h-5" />
        </x-admin.layouts.sidebar-link>

        {{-- 
        <x-admin.layouts.sidebar-link 
            :href="route('admin.products.index')" 
            :active="request()->routeIs('admin.products.*')" 
            title="Products">
            <x-admin.icon.box class="w-5 h-5" />
        </x-admin.layouts.sidebar-link> 
        --}}

    </nav>
    
    <div class="border-t border-gray-100 p-4 bg-gray-50/50">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm border border-gray-300">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                    Staff
                </p>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors p-1" title="Sign Out">
                    <x-admin.icon.logout class="w-5 h-5" />
                </button>
            </form>
        </div>
    </div>
</div>