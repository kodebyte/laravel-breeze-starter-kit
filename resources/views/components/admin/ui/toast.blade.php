<div x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        timer: null,
        progress: 100,
        init() {
            @if(session('status'))
                this.showToast('{{ session('status') }}', 'success');
            @elseif(session('error'))
                this.showToast('{{ session('error') }}', 'error');
            @endif
        },
        showToast(msg, type) {
            this.message = msg;
            this.type = type;
            this.show = true;
            this.progress = 100;
            
            if (this.timer) clearInterval(this.timer);
            
            const duration = 5000;
            const interval = 50;
            const step = (interval / duration) * 100;

            this.timer = setInterval(() => {
                this.progress -= step;
                if (this.progress <= 0) this.close();
            }, interval);
        },
        close() {
            this.show = false;
            clearInterval(this.timer);
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed top-5 right-5 z-[100] max-w-sm w-full bg-white border border-gray-100 rounded-xl shadow-2xl overflow-hidden shadow-gray-200/50"
    style="display: none;">
    
    <div class="p-4 flex items-start">
        <template x-if="type === 'success'">
            <div class="flex-shrink-0 text-green-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </template>

        <template x-if="type === 'error'">
            <div class="flex-shrink-0 text-red-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </template>

        <div class="ml-3 w-0 flex-1">
            <p class="text-sm font-bold text-gray-900" x-text="type === 'success' ? 'Success!' : 'Error!'"></p>
            <p class="mt-0.5 text-sm text-gray-500 leading-relaxed" x-text="message"></p>
        </div>

        <button @click="close()" class="ml-4 flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    @if(session('undo_route'))
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">Mistake?</span>
            <form method="POST" action="{{ session('undo_route') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors uppercase tracking-widest">
                    <x-admin.icon.undo class="w-3.5 h-3.5" />
                    <span>Undo Action</span>
                </button>
            </form>
        </div>
    @endif

    <div class="h-1 bg-gray-100 w-full">
        <div class="h-full transition-all ease-linear"
             :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
             :style="`width: ${progress}%`"
             style="transition-duration: 50ms;"></div>
    </div>
</div>