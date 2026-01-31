<x-admin.layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        
        <x-admin.ui.card>
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Anda login sebagai <span class="font-bold text-primary">{{ Auth::user()->roles->first()->name ?? 'Staff' }}</span>.
                    </p>
                </div>
                </div>
        </x-admin.ui.card>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <x-admin.ui.card class="border-l-4 border-primary">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary/10 text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Staff</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_employees'] }}</p>
                    </div>
                </div>
            </x-admin.ui.card>

            <x-admin.ui.card class="border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Active Roles</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_roles'] }}</p>
                    </div>
                </div>
            </x-admin.ui.card>

            <x-admin.ui.card class="border-l-4 border-gray-500">
                 <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gray-100 text-gray-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Projects (Soon)</p>
                        <p class="text-2xl font-bold text-gray-900">-</p>
                    </div>
                </div>
            </x-admin.ui.card>

        </div>
    </div>
</x-admin.layouts.app>