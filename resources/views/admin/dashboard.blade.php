<x-admin.layouts.app title="Dashboard">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Dashboard
                </h2>
                <p class="text-xs text-gray-500 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
            
            <div class="text-sm text-gray-500 font-medium bg-white px-3 py-1 rounded-lg border border-gray-200 shadow-sm">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        
        {{-- 1. STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Card 1: Total Users --}}
            <x-admin.card.stat 
                label="Total Users" 
                :value="$totalUsers" 
                color="primary" 
                href="{{ route('admin.users.index') }}"
            >
                <x-slot name="icon">
                    <x-admin.icon.users class="w-6 h-6" />
                </x-slot>
                {{-- Contoh Trend (Hardcoded dulu atau dari controller) --}}
                <x-slot name="trend">
                    <span class="inline-flex items-center text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        +12% Growth
                    </span>
                </x-slot>
            </x-admin.card.stat>

            {{-- Card 2: Employees --}}
            <x-admin.card.stat 
                label="Total Employees" 
                :value="$totalEmployees" 
                color="info" 
                href="{{ route('admin.employees.index') }}"
            >
                <x-slot name="icon">
                    <x-admin.icon.briefcase class="w-6 h-6" />
                </x-slot>
                <x-slot name="trend">
                    <span class="text-xs text-gray-400">Active personnel</span>
                </x-slot>
            </x-admin.card.stat>

            {{-- Card 3: Roles --}}
            <x-admin.card.stat 
                label="Active Roles" 
                :value="$totalRoles" 
                color="purple" 
                href="{{ route('admin.roles.index') }}"
            >
                <x-slot name="icon">
                    <x-admin.icon.shield class="w-6 h-6" />
                </x-slot>
            </x-admin.card.stat>

            {{-- Card 4: System Logs (Hari Ini) --}}
            <x-admin.card.stat 
                label="Activity Today" 
                :value="$todayLogs" 
                color="warning" 
                href="{{ route('admin.logs.index') }}"
            >
                <x-slot name="icon">
                    <x-admin.icon.activity class="w-6 h-6" />
                </x-slot>
                <x-slot name="trend">
                    <span class="inline-flex items-center text-xs font-medium text-gray-500">
                        Latest: {{ now()->format('H:i') }}
                    </span>
                </x-slot>
            </x-admin.card.stat>

        </div>

        {{-- 2. RECENT ACTIVITY & SHORTCUTS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left: Recent Activity Table (Reuse Component Table) --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden h-full flex flex-col">
                    <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <x-admin.icon.activity class="w-5 h-5 text-gray-400" />
                            Recent Activities
                        </h3>
                        <a href="{{ route('admin.logs.index') }}" class="text-xs font-bold text-primary hover:text-blue-700">View All</a>
                    </div>
                    
                    <div class="flex-1 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-50">
                            <tbody class="divide-y divide-gray-50">
                                @foreach($recentLogs as $log)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                                        {{ substr($log->causer->name ?? 'S', 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $log->causer->name ?? 'System' }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $log->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $log->description == 'created' ? 'bg-green-100 text-green-800' : ($log->description == 'deleted' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($log->description) }}
                                            </span>
                                            <span class="text-xs text-gray-500 ml-1">
                                                {{ class_basename($log->subject_type) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right: Quick Actions / System Health --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden p-6">
                <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.users.create') }}" class="flex items-center p-3 rounded-lg border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-all group">
                        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-3 group-hover:bg-blue-200">
                            <x-admin.icon.plus class="w-5 h-5" />
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Add New User</span>
                            <span class="block text-xs text-gray-500">Create a customer account</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.employees.create') }}" class="flex items-center p-3 rounded-lg border border-gray-100 hover:border-teal-200 hover:bg-teal-50 transition-all group">
                        <div class="p-2 bg-teal-100 text-teal-600 rounded-lg mr-3 group-hover:bg-teal-200">
                            <x-admin.icon.briefcase class="w-5 h-5" />
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-900">New Employee</span>
                            <span class="block text-xs text-gray-500">Onboard active staff</span>
                        </div>
                    </a>

                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">System Status</h4>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-600">Maintenance Mode</span>
                            <span class="font-bold {{ \App\Models\Setting::get('maintenance_mode') ? 'text-red-600' : 'text-green-600' }}">
                                {{ \App\Models\Setting::get('maintenance_mode') ? 'Active' : 'Off' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Laravel Version</span>
                            <span class="font-mono text-gray-500">{{ app()->version() }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layouts.app>