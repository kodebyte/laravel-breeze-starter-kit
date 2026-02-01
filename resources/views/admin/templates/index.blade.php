<x-admin.layouts.app title="Resource Management">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'System' => '#', 
                    'Resources' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Manage Resources
                </h2>
            </div>
            {{-- Action Button (Create) --}}
            <x-admin.ui.button href="#" color="primary">
                <x-admin.icon.plus class="w-4 h-4 mr-2" />
                Add New Resource
            </x-admin.ui.button>
        </div>
    </x-slot>

    {{-- SINGLE CARD LAYOUT --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        
        {{-- 1. TOOLBAR SECTION (Search & Filter) --}}
        <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row gap-4 justify-between items-center bg-gray-50/50">
            
            {{-- Search Input --}}
            <div class="w-full md:w-96 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                       name="search"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm transition duration-150 ease-in-out" 
                       placeholder="Search data..."
                       value="{{ request('search') }}">
            </div>

            {{-- Filter Buttons (Optional) --}}
            <div class="flex items-center gap-2">
                <button class="inline-flex items-center px-3 py-2 border border-gray-200 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
                <button class="inline-flex items-center px-3 py-2 border border-gray-200 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
            </div>
        </div>

        {{-- 2. TABLE SECTION --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Info / Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Role / Department
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Date Added
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- LOOP DATA HERE --}}
                    @for ($i = 0; $i < 3; $i++) 
                    <tr class="hover:bg-gray-50 transition-colors group">
                        
                        {{-- Column 1: Identity --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-9 w-9">
                                    {{-- Avatar Placeholder --}}
                                    <div class="h-9 w-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                        JD
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">John Doe</div>
                                    <div class="text-xs text-gray-500">john@kodebyte.id</div>
                                </div>
                            </div>
                        </td>

                        {{-- Column 2: Status (Badge) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>

                        {{-- Column 3: Metadata --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            Administrator
                        </td>

                        {{-- Column 4: Date --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            24 Jan 2026
                        </td>

                        {{-- Column 5: Actions --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="#" class="p-1.5 bg-white border border-gray-200 rounded-lg text-gray-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                                    <x-admin.icon.edit class="w-4 h-4" />
                                </a>
                                <button class="p-1.5 bg-white border border-gray-200 rounded-lg text-gray-400 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                                    <x-admin.icon.trash class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endfor
                    
                    {{-- 3. EMPTY STATE (Tampilkan jika data kosong) --}}
                    {{-- 
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h3 class="text-gray-900 font-bold text-lg">No Resources Found</h3>
                                <p class="text-gray-500 text-sm mt-1 mb-4">
                                    We couldn't find any data matching your search.
                                </p>
                                <x-admin.ui.button href="#" color="secondary" size="sm">
                                    Clear Search
                                </x-admin.ui.button>
                            </div>
                        </td>
                    </tr>
                    --}}

                </tbody>
            </table>
        </div>

        {{-- 4. PAGINATION FOOTER --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Showing <span class="font-bold">1</span> to <span class="font-bold">10</span> of <span class="font-bold">24</span> results
            </p>
            
            {{-- Pagination Component Laravel biasanya langsung {!! $users->links() !!} --}}
            <div class="flex gap-1">
                <button class="px-3 py-1 text-xs border border-gray-200 rounded bg-white text-gray-500 hover:bg-gray-50" disabled>Prev</button>
                <button class="px-3 py-1 text-xs border border-primary bg-primary text-white rounded">1</button>
                <button class="px-3 py-1 text-xs border border-gray-200 rounded bg-white text-gray-700 hover:bg-gray-50">2</button>
                <button class="px-3 py-1 text-xs border border-gray-200 rounded bg-white text-gray-700 hover:bg-gray-50">Next</button>
            </div>
        </div>

    </div>
</x-admin.layouts.app>