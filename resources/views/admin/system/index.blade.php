<x-admin.layouts.app title="System Health">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['System' => '#', 'Health Status' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    System Health
                </h2>
            </div>
            
            {{-- Shortcut ke Log Viewer --}}
            <a href="{{ url('log-viewer') }}" target="_blank" class="flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition font-bold text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Open Log Viewer
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        
        {{-- SECTION 1: DATABASE & APPLICATION --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Application Info Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    Application Env
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500 text-sm">Laravel Version</span>
                        <span class="font-mono font-bold text-gray-800">{{ $serverInfo['laravel_version'] }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500 text-sm">PHP Version</span>
                        <span class="font-mono font-bold text-gray-800">{{ $serverInfo['php_version'] }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500 text-sm">Environment</span>
                        <span class="font-bold uppercase {{ app()->environment('production') ? 'text-green-600' : 'text-orange-500' }}">
                            {{ app()->environment() }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Debug Mode</span>
                        <span class="font-bold {{ config('app.debug') ? 'text-red-500' : 'text-green-600' }}">
                            {{ config('app.debug') ? 'ENABLED' : 'DISABLED' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Database Info Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                    Database Status
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500 text-sm">Connection</span>
                        <span class="font-bold text-gray-800">{{ $serverInfo['db_connection'] }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-500 text-sm">Status</span>
                        @if($serverInfo['db_status'])
                            <span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full flex items-center gap-1">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Connected
                            </span>
                        @else
                             <span class="px-2 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full">Error</span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Size (Approx)</span>
                        <span class="font-mono font-bold text-gray-800">{{ $serverInfo['db_size'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: STORAGE INFO --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                </svg>
                Storage Usage (Root Disk)
            </h3>
            
            <div class="mb-2 flex justify-between text-sm font-bold text-gray-700">
                <span>Used: {{ $serverInfo['disk_used'] }}</span>
                <span>Total: {{ $serverInfo['disk_total'] }}</span>
            </div>
            
            {{-- Progress Bar --}}
            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full transition-all duration-1000" 
                     style="width: {{ $serverInfo['disk_percentage'] }}%">
                </div>
            </div>
            
            <div class="mt-2 text-right">
                <span class="text-xs font-bold {{ $serverInfo['disk_percentage'] > 90 ? 'text-red-500' : 'text-green-600' }}">
                    {{ $serverInfo['disk_free'] }} Free Space
                </span>
            </div>
        </div>
    </div>
</x-admin.layouts.app>