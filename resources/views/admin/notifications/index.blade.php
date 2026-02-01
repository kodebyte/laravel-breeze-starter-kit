<x-admin.layouts.app title="Notifications">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <x-admin.ui.breadcrumb :links="['Notifications' => '#']" />
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Notifications Center
                </h2>
            </div>
        </div>
    </x-slot>

    {{-- SINGLE CARD LAYOUT --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        
        {{-- CARD HEADER: Title & Quick Actions --}}
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            {{-- Left: Identity --}}
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-primary rounded-xl">
                    <x-admin.icon.bell class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">All Notifications</h3>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        <p class="text-xs text-gray-500 font-medium">
                            You have <span class="text-gray-900 font-bold">{{ auth()->user()->unreadNotifications->count() }}</span> unread messages
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center gap-3">
                {{-- Mark All as Read --}}
                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 uppercase tracking-widest hover:bg-gray-50 hover:text-primary transition-colors shadow-sm">
                        <x-admin.icon.check-double class="w-4 h-4 mr-2" /> Mark All Read
                    </button>
                </form>

                {{-- Clear All (Trigger Modal) --}}
                <button type="button" 
                    @click="$dispatch('open-modal', 'confirm-delete-all')"
                    class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-100 rounded-lg text-xs font-bold text-red-600 uppercase tracking-widest hover:bg-red-100 hover:text-red-700 transition-colors shadow-sm">
                    <x-admin.icon.trash class="w-4 h-4 mr-2" /> Clear All
                </button>
            </div>
        </div>

        {{-- CARD BODY: List Notifications --}}
        <div class="divide-y divide-gray-50">
            @forelse($notifications as $notification)
                <div class="p-5 flex items-start gap-4 {{ $notification->unread() ? 'bg-blue-50/30' : 'hover:bg-gray-50' }} transition-colors group">
                    {{-- Icon Status --}}
                    <div class="mt-1 flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center border {{ $notification->unread() ? 'bg-white border-blue-100 text-primary shadow-sm' : 'bg-gray-50 border-gray-100 text-gray-400' }}">
                            @if($notification->data['type'] == 'danger')
                                <x-admin.icon.cone class="w-5 h-5 text-red-500" />
                            @elseif($notification->data['type'] == 'warning')
                                <x-admin.icon.lock class="w-5 h-5 text-orange-500" />
                            @else
                                <x-admin.icon.bell class="w-5 h-5" />
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-sm font-bold {{ $notification->unread() ? 'text-gray-900' : 'text-gray-600' }}">
                                {{ $notification->data['title'] }}
                            </h4>
                            <span class="text-[10px] text-gray-400 font-mono">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 leading-relaxed max-w-2xl">
                            {{ $notification->data['message'] }}
                        </p>

                        @if(isset($notification->data['url']))
                            <div class="mt-2">
                                <a href="{{ $notification->data['url'] }}" class="inline-flex items-center text-xs font-bold text-primary hover:text-blue-700 hover:underline">
                                    View Details <x-admin.icon.arrow-right class="w-3 h-3 ml-1" />
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Item Actions --}}
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        @if($notification->unread())
                            <form action="{{ route('admin.notifications.mark-as-read', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="p-2 text-gray-400 hover:text-primary bg-white hover:bg-blue-50 rounded-lg border border-transparent hover:border-blue-100 transition-all" title="Mark as read">
                                    <x-admin.icon.check-circle class="w-5 h-5" />
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Delete this notification?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 bg-white hover:bg-red-50 rounded-lg border border-transparent hover:border-red-100 transition-all" title="Delete">
                                <x-admin.icon.trash class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-20 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <x-admin.icon.bell class="w-8 h-8 text-gray-300" />
                    </div>
                    <h3 class="text-gray-900 font-bold text-lg">No Notifications</h3>
                    <p class="text-gray-500 text-sm mt-1 max-w-sm">
                        You're all caught up! There are no new notifications to display at this time.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- CARD FOOTER: Pagination --}}
        @if($notifications->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL KONFIRMASI (Tetap Sama) --}}
    <x-admin.ui.modal name="confirm-delete-all" title="Clear All Notifications">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <x-admin.icon.trash class="w-6 h-6 text-red-600" />
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Are you sure?</h3>
            <p class="text-sm text-gray-500 text-center mb-6 leading-relaxed">
                This action will permanently delete all your notifications.<br>This process cannot be undone.
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
                    <x-admin.ui.button color="danger">
                        Yes, Clear All
                    </x-admin.ui.button>
                </form>
            </div>
        </div>
    </x-admin.ui.modal>

</x-admin.layouts.app>