<x-admin.layouts.app title="Read Message">
    {{-- HEADER WITH BREADCRUMB --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="[
                    'Inbox Messages' => route('admin.inquiries.index'),
                    'Read Message' => '#'
                ]" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Read Message
                </h2>
            </div>
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.inquiries.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-xl text-gray-700 font-bold text-sm shadow-sm hover:bg-gray-50 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Inbox
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- ================================================= --}}
        {{-- KOLOM KIRI (UTAMA): MESSAGE CONTENT (2/3) --}}
        {{-- ================================================= --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col min-h-[400px]">
                
                {{-- Header Message --}}
                <div class="p-6 border-b border-gray-100">
                     <div class="flex items-start gap-3">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h1 class="text-lg font-bold text-gray-900 leading-snug">
                                {{ $inquiry->subject ?? '(No Subject)' }}
                            </h1>
                            <p class="text-xs text-gray-500 mt-1">
                                Received on {{ $inquiry->created_at->format('l, d F Y') }} at {{ $inquiry->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Body Message --}}
                <div class="p-8 flex-1">
                    <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line font-normal text-sm">
                        {{ $inquiry->message }}
                    </div>
                </div>
                
                {{-- Footer Action --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-xs text-gray-400">
                        @if($inquiry->is_read)
                            Status: <span class="text-green-600 font-bold">Read</span>
                        @else
                            Status: <span class="text-blue-600 font-bold">New</span>
                        @endif
                    </span>

                    {{-- Delete Button --}}
                    @can('inquiries.delete')
                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                            @csrf
                            @method('DELETE')
                            <x-admin.ui.button type="submit" class="bg-white border border-gray-300 text-red-600 hover:bg-red-50 hover:border-red-200 shadow-none !px-4">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Delete Permanently
                                </span>
                            </x-admin.ui.button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

        {{-- ================================================= --}}
        {{-- KOLOM KANAN (SIDEBAR): SENDER INFO (1/3) --}}
        {{-- ================================================= --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden h-fit">
            <div class="p-6">
                {{-- Header Card Style --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                        {{-- Icon User --}}
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Sender Details</h3>
                        <p class="text-xs text-gray-500">Information about the sender.</p>
                    </div>
                </div>

                {{-- List Info --}}
                <div class="space-y-4">
                    {{-- Name --}}
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">Full Name</label>
                        <div class="font-medium text-gray-900 text-sm mt-1">{{ $inquiry->name }}</div>
                    </div>

                    {{-- Email & Action --}}
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">Email Address</label>
                        <div class="font-medium text-gray-900 text-sm mt-1 flex items-center justify-between">
                            <span class="truncate">{{ $inquiry->email }}</span>
                        </div>
                        <a href="mailto:{{ $inquiry->email }}" class="mt-2 w-full flex items-center justify-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Reply via Email
                        </a>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-bold tracking-wider">Phone Number</label>
                        <div class="font-medium text-gray-900 text-sm mt-1">
                            @if($inquiry->phone)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $inquiry->phone)) }}" target="_blank" class="hover:text-green-600 flex items-center gap-1 transition-colors">
                                    {{ $inquiry->phone }}
                                    <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.638 3.891 1.746 5.668l-.808 2.953 3.111-.817zm11.397-13.601c1.291 1.294 2.003 3.011 2.004 4.839-.002 3.784-3.072 6.862-6.871 6.861-1.875-.001-3.593-.738-4.869-2.035-1.267-1.288-1.966-3.001-1.965-4.831.001-3.784 3.073-6.862 6.871-6.861 1.815.001 3.523.725 4.83 2.027zm-8.288 3.295c.068-.112.138-.266.138-.475 0-.209-.764-2.859-1.046-3.918-.263-.984-.537-.852-.736-.867-.184-.014-.395-.017-.604-.017-.21 0-.551.079-.839.395-.288.316-1.101 1.076-1.101 2.625s1.127 3.047 1.284 3.257c.158.211 2.218 3.388 5.372 4.752 3.154 1.364 3.154.91 3.731.854.577-.056 1.839-.751 2.099-1.477.262-.726.262-1.348.183-1.477-.078-.129-.288-.207-.603-.365-.315-.158-1.839-.907-2.126-1.013-.287-.105-.497-.158-.707.158-.21.317-.812 1.013-.996 1.224-.183.21-.367.236-.682.079-.315-.158-1.328-.489-2.531-1.561-.941-.839-1.576-1.875-1.76-2.244-.184-.368-.02-.567.138-.725.143-.142.316-.368.473-.553.158-.184.21-.316.315-.526.106-.211.053-.395-.026-.553z"/></svg>
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tech Info (Footer Card) --}}
                <div class="mt-8 pt-4 border-t border-gray-100">
                    <div class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <div class="text-[10px] text-gray-400 leading-relaxed">
                            <span class="block font-bold text-gray-500 uppercase">Technical Details</span>
                            IP Address: {{ $inquiry->ip_address ?? 'Unknown' }}<br>
                            Device: {{ $inquiry->user_agent }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin.layouts.app>