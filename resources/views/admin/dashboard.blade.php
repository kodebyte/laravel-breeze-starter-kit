<x-admin.layouts.app title="Dashboard">
    <x-slot name="header">
        <x-admin.ui.breadcrumb :links="['Dashboard' => '#']" />
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            Dashboard Overview
        </h2>
    </x-slot>

    <div class="space-y-8">
        {{-- 1. STATS CARDS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Card 1: Total Employees --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-primary/50 transition-colors">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Staff</p>
                    <p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['total_employees'] }}</p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <x-admin.icon.users class="w-6 h-6" />
                </div>
            </div>

            {{-- Card 2: Active Employees --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-green-300 transition-colors">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Now</p>
                    <p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['active_employees'] }}</p>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Card 3: Security Alerts (Locked Accounts) --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-red-300 transition-colors">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Locked Accounts</p>
                    <p class="text-2xl font-black {{ $stats['locked_accounts'] > 0 ? 'text-red-600' : 'text-gray-900' }} mt-1">
                        {{ $stats['locked_accounts'] }}
                    </p>
                </div>
                <div class="p-3 {{ $stats['locked_accounts'] > 0 ? 'bg-red-50 text-red-600 animate-pulse' : 'bg-gray-50 text-gray-400' }} rounded-lg">
                    <x-admin.icon.lock class="w-6 h-6" />
                </div>
            </div>

            {{-- Card 4: System Status --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-orange-300 transition-colors">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">System Mode</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $stats['system_status'] == 'Live' ? 'bg-green-400' : 'bg-red-400' }} opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 {{ $stats['system_status'] == 'Live' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        </span>
                        <p class="text-lg font-bold text-gray-900">{{ $stats['system_status'] }}</p>
                    </div>
                </div>
                <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                    <x-admin.icon.settings class="w-6 h-6" />
                </div>
            </div>

        </div>

        {{-- 2. RECENT EMPLOYEES TABLE --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Recently Added Employees</h3>
                @can('employees.view')
                    <a href="{{ route('admin.employees.index') }}" class="text-sm text-primary font-bold hover:underline">View All</a>
                @endcan
            </div>
            
            <x-admin.table>
                <x-admin.table.thead>
                    <x-admin.table.th label="Employee" />
                    <x-admin.table.th label="Role" />
                    <x-admin.table.th label="Status" />
                    <x-admin.table.th label="Joined At" />
                </x-admin.table.thead>
                <x-admin.table.tbody>
                    @foreach($recentEmployees as $emp)
                        <x-admin.table.tr>
                            <x-admin.table.td>
                                <div class="font-bold text-gray-900">{{ $emp->name }}</div>
                                <div class="text-xs text-gray-400">{{ $emp->email }}</div>
                            </x-admin.table.td>
                            <x-admin.table.td>
                                <x-admin.ui.badge :label="$emp->roles->first()->name ?? '-'" color="gray" />
                            </x-admin.table.td>
                            <x-admin.table.td>
                                <x-admin.ui.badge 
                                    :label="$emp->status->label()" 
                                    :color="$emp->status->value === 'active' ? 'emerald' : 'red'" 
                                />
                            </x-admin.table.td>
                            <x-admin.table.td class="text-gray-500">
                                {{ $emp->created_at->diffForHumans() }}
                            </x-admin.table.td>
                        </x-admin.table.tr>
                    @endforeach
                </x-admin.table.tbody>
            </x-admin.table>
        </div>
    </div>
</x-admin.layouts.app>