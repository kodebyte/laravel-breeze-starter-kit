<x-admin.layouts.app title="All Notifications">
    <x-slot name="header">
        <div>
            <x-admin.ui.breadcrumb :links="['Notifications' => '#']" />
            <h2 class="font-bold text-xl text-gray-900 leading-tight">
                Notifications Center
            </h2>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- KIRI: List Notifikasi (Sisi Lebar) --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="divide-y divide-gray-50">
                    @forelse($notifications as $notification)
                        <div class="p-5 flex items-start gap-4 {{ $notification->unread() ? 'bg-primary/5' : '' }} transition-colors">
                            {{-- Icon Status --}}
                            <div class="mt-1">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $notification->unread() ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-400' }}">
                                    <x-admin.icon.bell class="w-4 h-4" />
                                </div>
                            </div>

                            {{-- Info Notifikasi --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-sm font-bold {{ $notification->unread() ? 'text-gray-900' : 'text-gray-500' }}">
                                        {{ $notification->data['title'] }}
                                    </h4>
                                    <span class="text-[10px] text-gray-400 font-medium">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-xs {{ $notification->unread() ? 'text-gray-700' : 'text-gray-400' }} leading-relaxed">
                                    {{ $notification->data['message'] }}
                                </p>
                                
                                {{-- Link Aksi (Jika ada URL) --}}
                                @if(isset($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="mt-3 inline-flex items-center text-[10px] font-bold text-primary hover:underline">
                                        View Details <x-admin.icon.arrow-right class="w-3 h-3 ml-1" />
                                    </a>
                                @endif
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- Mark as Read Button (Individual) --}}
                                @if($notification->unread())
                                    <form action="{{ route('admin.notifications.mark-as-read', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-primary transition-colors" title="Mark as read">
                                            <x-admin.icon.check-circle class="w-5 h-5" />
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete Individual --}}
                                <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notification?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors" title="Delete notification">
                                        <x-admin.icon.trash class="w-5 h-5" />
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-20 text-center">
                            <x-admin.icon.bell class="w-12 h-12 text-gray-200 mx-auto mb-4" />
                            <p class="text-sm text-gray-400 italic">No notifications found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>

        {{-- KANAN: Actions Sidebar (Sisi Sempit) --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="font-bold text-gray-900 border-b border-gray-50 pb-2">Quick Actions</h3>
                
                {{-- Tombol Mark All Read --}}
                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <x-admin.ui.button class="w-full justify-center" color="primary">
                        <x-admin.icon.check-double class="w-4 h-4 mr-2" /> Mark All as Read
                    </x-admin.ui.button>
                </form>

                {{-- Tombol Delete All (PASTIKAN color="danger") --}}
                <x-admin.ui.button 
                    type="button"
                    @click.prevent="$dispatch('open-modal', 'confirm-delete-all')" 
                    class="w-full justify-center" 
                    color="danger"> {{-- --}}
                    <x-admin.icon.trash class="w-4 h-4 mr-2" /> Clear All Notifications
                </x-admin.ui.button>

                <p class="text-[10px] text-gray-400 text-center italic">
                    Actions will affect your current notification status.
                </p>
            </div>

            {{-- Summary Card --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden group">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary/10 rounded-xl group-hover:scale-110 transition-transform duration-300">
                        <x-admin.icon.bell class="w-6 h-6 text-primary" />
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest leading-none mb-1">
                            Unread Messages
                        </p>
                        <div class="flex items-baseline gap-1">
                            <p class="text-3xl font-bold text-gray-900 leading-none">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </p>
                            <span class="text-xs text-gray-500 font-medium">Messages</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL KONFIRMASI --}}
    <x-admin.ui.modal name="confirm-delete-all" title="Clear All Notifications">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <x-admin.icon.trash class="w-6 h-6 text-red-600" />
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Are you sure?</h3>
            <p class="text-sm text-gray-500 text-center mb-6 leading-relaxed">
                This action will permanently delete all your notifications. This process cannot be undone.
            </p>

            <div class="flex justify-center gap-3">
                <x-admin.ui.button 
                    type="button" 
                    color="secondary" 
                    @click="$dispatch('close-modal', 'confirm-delete-all')">
                    Cancel
                </x-admin.ui.button>

                <form action="{{ route('admin.notifications.deleteAll') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    {{-- Tombol Konfirmasi (PASTIKAN color="danger") --}}
                    <x-admin.ui.button color="danger"> {{-- --}}
                        Yes, Clear All
                    </x-admin.ui.button>
                </form>
            </div>
        </div>
    </x-admin.ui.modal>
</x-admin.layouts.app>