{{-- ============================================================
TOAST SYSTEM — Alpine.js
Dari JS : window.showToast('Judul', 'Pesan', 'success')
Dari PHP : otomatis trigger dari session('success'/'error')
Types : success | error | info | warning
============================================================ --}}
<div x-data="{
        toasts: [],
        add(toast) {
            const id = Date.now();
            this.toasts.push({ id, ...toast });
            setTimeout(() => this.remove(id), toast.duration ?? 4500);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }" x-init="
        window.showToast = (title, message, type = 'success', duration = 4500) => {
            if (message) add({ title, message, type, duration });
        };
        @if(session('success') && strlen(session('success')) > 0)
        setTimeout(() => add({ title: 'Berhasil', message: @js(session('success')), type: 'success', duration: 4500 }), 300);
        @endif
        @if(session('error') && strlen(session('error')) > 0)
        setTimeout(() => add({ title: 'Gagal', message: @js(session('error')), type: 'error', duration: 6000 }), 300);
        @endif
    " x-cloak class="fixed top-4 right-4 z-50 flex flex-col items-end gap-2" style="pointer-events: none;">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="true" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-x-4 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 translate-x-4 scale-95"
            class="flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg bg-white border w-80" :class="{
                'border-emerald-200': toast.type === 'success',
                'border-red-200':     toast.type === 'error',
                'border-blue-200':    toast.type === 'info',
                'border-amber-200':   toast.type === 'warning',
            }" style="pointer-events: all;">
            {{-- Icon --}}
            <div class="mt-0.5 flex-shrink-0">
                <template x-if="toast.type === 'success'">
                    <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </template>
                <template x-if="toast.type === 'error'">
                    <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </template>
                <template x-if="toast.type === 'info'">
                    <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </template>
                <template x-if="toast.type === 'warning'">
                    <div class="w-5 h-5 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                </template>
            </div>

            {{-- Text --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800" x-text="toast.title"></p>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed" x-text="toast.message"></p>
            </div>

            {{-- Close --}}
            <button @click="remove(toast.id)"
                class="flex-shrink-0 text-slate-300 hover:text-slate-500 transition-colors mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>