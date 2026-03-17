<x-layouts.app title="Tracking Pesanan {{ $order->order_code }}">

    {{-- Mobile Header --}}
    <div class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-100 px-5 py-4 flex items-center justify-between md:hidden shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('order.index', ['phone' => $order->customer_phone]) }}" aria-label="Kembali ke Daftar Pesanan" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-500 active:bg-slate-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-base font-extrabold text-slate-800 leading-none">Detail Pesanan</h1>
            {{-- Indikator Live --}}
            <span id="realtime-indicator-mobile" class="hidden items-center gap-1 text-[9px] font-black text-emerald-600 bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 rounded-full uppercase tracking-wider">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse inline-block"></span>Live
            </span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.location.reload()" aria-label="Refresh Halaman" title="Refresh manual" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 active:bg-slate-200 transition-colors hover:rotate-180 duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </button>
            <span class="text-[10px] font-black tracking-wider text-brand-primary bg-brand-secondary px-2 py-1 rounded-md uppercase">Antrean {{ $order->queue_number }}</span>
        </div>
    </div>

    <div class="px-5 py-6 md:px-8 lg:px-10 max-w-6xl mx-auto mb-10">
        
        {{-- Desktop Header --}}
        <div class="hidden md:flex items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-5">
                <a href="{{ route('order.index', ['phone' => $order->customer_phone]) }}" aria-label="Kembali ke Daftar Pesanan" class="w-12 h-12 flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-slate-500 hover:bg-slate-100 transition-colors shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-2xl lg:text-3xl font-black text-slate-800 tracking-tight">Pelacakan Pesanan</h1>
                        {{-- Indikator Live desktop (sama ID, JS toggle hidden→flex) --}}
                        <span id="realtime-indicator-desktop" class="hidden items-center gap-1.5 text-[10px] font-black text-emerald-600 bg-emerald-50 border border-emerald-200 px-2 py-1 rounded-full uppercase tracking-wider">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse inline-block"></span>Live
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">Pantau status pesanan dan pembayaran Anda secara real-time.</p>
                </div>
            </div>
            <div class="text-right flex flex-col items-end gap-3">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nomor Antrean Anda</p>
                    <div class="text-4xl font-black text-brand-primary">{{ $order->queue_number }}</div>
                </div>
                {{-- Tombol Refresh Manual Desktop --}}
                <button onclick="window.location.reload()" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 border border-slate-200 px-3 py-2 rounded-xl transition-all active:scale-95 group">
                    <svg class="w-3.5 h-3.5 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Refresh Manual
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8 xl:gap-10">
            
            {{-- Kiri: Detail, Instruksi, Timeline --}}
            <div class="xl:col-span-7 space-y-6">

                {{-- Card Info Pemesan Terpadu --}}
                <div class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-slate-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-secondary/50 rounded-bl-[100px] -z-0"></div>
                    
                    <div class="p-5 md:p-6 border-b border-dashed border-slate-200 relative z-10 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Kode Pesanan</p>
                            <p class="text-sm md:text-base font-black text-slate-800 tracking-tight">{{ $order->order_code }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Waktu Pesan</p>
                            <p class="text-xs md:text-sm font-bold text-slate-800">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="p-5 md:p-6 grid grid-cols-2 gap-y-5 gap-x-4 relative z-10 bg-white/50 backdrop-blur-sm">
                        <div>
                            <p class="text-[10px] md:text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1.5 md:mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Pemesan
                            </p>
                            <p class="text-xs md:text-sm font-bold text-slate-800 leading-snug line-clamp-1 mb-0.5">{{ $order->customer_name }}</p>
                            <p class="text-[10px] md:text-xs font-medium text-slate-500 font-mono">{{ $order->customer_phone }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] md:text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1.5 md:mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                Tipe Pesanan
                            </p>
                            <div class="inline-flex items-center gap-1.5 bg-brand-secondary text-brand-primary px-2 md:px-2.5 py-1 rounded w-max">
                                @if($order->order_type === 'dine_in')
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span class="text-[11px] md:text-xs font-bold leading-none mt-px">Dine In</span>
                                @else
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span class="text-[11px] md:text-xs font-bold leading-none mt-px">Takeaway</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] md:text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1.5 md:mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Status Bayar
                            </p>
                            {{-- payment-status-wrapper: diupdate realtime oleh order-tracker.js --}}
                        <div class="flex flex-col gap-1 items-start w-max">
                            <div id="payment-status-wrapper" class="flex items-center gap-1.5">
                                @if($order->payment->status === 'verified')
                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-100 text-emerald-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <span class="text-xs md:text-sm font-black text-emerald-600 uppercase tracking-widest">Lunas</span>
                                @elseif($order->payment->status === 'uploaded')
                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-blue-100 text-blue-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </span>
                                    <span class="text-xs md:text-sm font-black text-blue-600 uppercase tracking-widest">Menunggu</span>
                                @else
                                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-red-100 text-red-600">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </span>
                                    <span class="text-xs md:text-sm font-black text-red-600 uppercase tracking-widest">Belum</span>
                                @endif
                            </div>
                            <span class="text-[9px] md:text-[10px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded capitalize mt-0.5">Metode: {{ $order->payment->method }}</span>
                        </div>
                        </div>
                        <div>
                            <p class="text-[10px] md:text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1.5 md:mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                Status Pesanan
                            </p>
                            {{-- order-status-badge + order-status-text: diupdate realtime --}}
                            <span id="order-status-badge" class="text-sm md:text-base font-black text-slate-800 capitalize">
                                <span id="order-status-text">{{ $order->status_label }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- ❌ Banner Pembayaran Ditolak --}}
                @if($order->payment && $order->payment->status === 'rejected')
                    <div class="bg-red-50 border border-red-200 rounded-2xl md:rounded-3xl p-5 md:p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-red-100/60 rounded-full -translate-y-8 translate-x-8"></div>

                        <div class="flex items-start gap-3 mb-4 relative">
                            <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center shrink-0 shadow-sm shadow-red-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-red-700 text-sm md:text-base leading-tight">Pembayaran Ditolak</h3>
                                <p class="text-[11px] md:text-xs text-red-500 mt-0.5">Admin tidak dapat memverifikasi pembayaran Anda.</p>
                            </div>
                        </div>

                        @if($order->payment->reject_reason)
                            <div class="bg-red-100/70 border border-red-200/60 rounded-xl p-3.5 mb-4">
                                <p class="text-[10px] md:text-[11px] text-red-500 font-bold uppercase tracking-wider mb-1">Alasan Penolakan</p>
                                <p class="text-sm font-semibold text-red-700">{{ $order->payment->reject_reason }}</p>
                            </div>
                        @endif

                        <a href="{{ route('menu.index') }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-sm transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Pesan Ulang
                        </a>
                    </div>
                @endif

                {{-- ⏳ Menunggu Konfirmasi Admin (semua metode, jika belum verified & bukan rejected) --}}
                @if($order->payment && $order->payment->status === 'pending')
                    @if($order->payment->method === 'cash')
                        {{-- Cash: Bayar di kasir --}}
                        <div class="bg-brand-secondary rounded-2xl md:rounded-3xl border border-brand-primary/10 p-5 md:p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-brand-secondary text-brand-primary rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-extrabold text-brand-dark">Pembayaran Tunai / Debit</h3>
                                    <p class="text-[10px] text-brand-primary mt-0.5">Bayar langsung di kasir</p>
                                </div>
                            </div>
                            <div class="bg-white/70 rounded-xl p-3 border border-brand-primary/10 text-center">
                                <p class="text-xs md:text-sm text-brand-dark font-medium">Sebutkan <strong>Nomor Antrean #{{ $order->queue_number }}</strong> kepada kasir kami untuk menyelesaikan pembayaran.</p>
                            </div>
                        </div>

                    @elseif($order->payment->method === 'qris')
                        {{-- QRIS: Tampilkan QR code --}}
                        <div class="bg-purple-50/50 rounded-2xl md:rounded-3xl border border-purple-100 p-5 md:p-6"
                             x-data="{ showQrisModal: false }">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-extrabold text-purple-900">QRIS</h3>
                                        <p class="text-[10px] text-purple-600 mt-0.5">Scan & bayar, admin otomatis konfirmasi</p>
                                    </div>
                                </div>

                            </div>

                            @php $qris = \App\Models\QrisSetting::getActive(); @endphp
                            @if($qris && $qris->image)
                            <div class="bg-white rounded-xl p-5 border border-purple-100 mb-3 shadow-sm text-center">
                                <p class="text-slate-600 text-xs mb-3">Scan untuk bayar <strong class="text-slate-900 bg-brand-secondary px-1 py-0.5 rounded">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                                <img @click="showQrisModal = true" src="{{ asset('storage/' . $qris->image) }}" alt="QRIS" loading="lazy" class="w-48 h-48 object-contain mx-auto rounded-lg border border-slate-100 p-1.5 shadow-sm cursor-pointer hover:border-brand-primary/30 transition-colors bg-white">
                                <div class="mt-3 flex items-center justify-center gap-2">
                                    <button @click="showQrisModal = true" type="button" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-primary bg-brand-secondary hover:bg-brand-secondary/80 border border-brand-primary/10 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>Perbesar
                                    </button>
                                    <a href="{{ asset('storage/' . $qris->image) }}" download="QRIS_{{ Str::slug($qris->merchant_name) }}.png" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>Simpan QR
                                    </a>
                                </div>
                                <p class="text-[10px] font-bold text-slate-800 mt-2">{{ $qris->merchant_name }}</p>
                            </div>

                            {{-- QRIS modal --}}
                            <template x-teleport="body">
                                <div x-show="showQrisModal" style="display:none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                    <div class="absolute inset-0" @click="showQrisModal = false"></div>
                                    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
                                        <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                            <h3 class="font-bold text-slate-800 text-sm">Scan QRIS</h3>
                                            <button @click="showQrisModal = false" aria-label="Tutup Banner QRIS" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 text-slate-500 hover:bg-slate-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 bg-white flex flex-col items-center">
                                            <img src="{{ asset('storage/' . $qris->image) }}" alt="QRIS Besar" class="w-full max-w-[280px] h-auto object-contain mb-4">
                                            <p class="font-bold text-slate-800 text-sm text-center">{{ $qris->merchant_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            @endif

                            <div class="flex items-center gap-2 bg-purple-100/50 rounded-xl p-3 border border-purple-100">
                                <svg class="w-4 h-4 text-purple-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                <p class="text-[11px] text-purple-700 font-medium">Tidak perlu kirim bukti. Admin akan memverifikasi pembayaran setelah notifikasi QRIS masuk.</p>
                            </div>
                        </div>
                    @endif
                @endif



                {{-- Live Tracking Timeline Card --}}
                <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-sm border border-slate-100 relative overflow-hidden">
                    <h3 class="text-xs md:text-sm font-extrabold text-slate-800 uppercase tracking-widest mb-6 md:mb-8">Timeline Status</h3>

                    @php
                        $statusFlow = ['pending', 'confirmed', 'in_progress', 'ready', 'completed'];
                        $currentIndex = array_search($order->status, $statusFlow) ?? -1;
                    @endphp

                    <div class="relative pl-2 lg:pl-4 space-y-7 before:absolute before:inset-0 before:left-[1.4rem] lg:before:left-[1.9rem] before:-translate-x-px before:h-[90%] before:w-[2px] before:bg-slate-100">

                        {{-- Step 1: Pesanan Diterima (pending) --}}
                        @php $done1 = $currentIndex >= 0; @endphp
                        <div id="step-row-pending" class="relative flex items-start gap-4 lg:gap-6">
                            <div id="step-circle-pending" class="flex-shrink-0 w-8 h-8 lg:w-10 lg:h-10 rounded-full border-4 border-white {{ $done1 ? 'bg-brand-primary shadow-sm' : 'bg-slate-200' }} text-white flex items-center justify-center transition-colors duration-500">
                                @if($done1)
                                    <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-white opacity-50"></div>
                                @endif
                            </div>
                            <div class="pt-0.5 lg:pt-1">
                                <h4 id="step-title-pending" class="text-sm lg:text-base font-bold leading-tight {{ $done1 ? 'text-slate-800' : 'text-slate-400' }}">Pesanan Diterima</h4>
                                <div id="step-subtitle-pending"><p class="text-[10px] lg:text-[11px] text-slate-400 font-medium mt-0.5">{{ $order->created_at->format('H:i') }} WIB</p></div>
                            </div>
                        </div>

                        {{-- Step 2: Dikonfirmasi (confirmed) --}}
                        @php $done2 = $currentIndex >= 1; $active2 = $order->status === 'confirmed'; @endphp
                        <div id="step-row-confirmed" class="relative flex items-start gap-4 lg:gap-6 {{ $active2 ? 'animate-pulse' : '' }}">
                            <div id="step-circle-confirmed" class="flex-shrink-0 w-8 h-8 lg:w-10 lg:h-10 rounded-full border-4 border-white {{ $done2 ? 'bg-brand-primary shadow-sm' : 'bg-slate-200' }} text-white flex items-center justify-center transition-colors duration-500">
                                @if($done2)
                                    <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-white opacity-50"></div>
                                @endif
                            </div>
                            <div class="pt-0.5 lg:pt-1">
                                <h4 id="step-title-confirmed" class="text-sm lg:text-base font-bold leading-tight {{ $done2 ? 'text-slate-800' : 'text-slate-400' }}">Pembayaran Dikonfirmasi</h4>
                                <div id="step-subtitle-confirmed">
                                    @if($done2 && $order->confirmed_at)
                                        <p class="text-[10px] lg:text-[11px] text-slate-400 font-medium mt-0.5">{{ $order->confirmed_at->format('H:i') }} WIB</p>
                                    @elseif($active2)
                                        <p class="text-[10px] lg:text-[11px] text-brand-primary bg-brand-secondary px-2 py-0.5 rounded font-bold mt-1 max-w-max">Menunggu diproses dapur</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Sedang Disiapkan (in_progress) --}}
                        @php $done3 = $currentIndex >= 2; $active3 = $order->status === 'in_progress'; @endphp
                        <div id="step-row-in_progress" class="relative flex items-start gap-4 lg:gap-6 {{ $active3 ? 'animate-pulse' : '' }}">
                            <div id="step-circle-in_progress" class="flex-shrink-0 w-8 h-8 lg:w-10 lg:h-10 rounded-full border-4 border-white {{ $done3 ? 'bg-brand-primary shadow-sm' : 'bg-slate-200' }} text-white flex items-center justify-center transition-colors duration-500">
                                @if($done3)
                                    <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-white opacity-50"></div>
                                @endif
                            </div>
                            <div class="pt-0.5 lg:pt-1">
                                <h4 id="step-title-in_progress" class="text-sm lg:text-base font-bold leading-tight {{ $done3 ? 'text-slate-800' : 'text-slate-400' }}">Sedang Disiapkan</h4>
                                <div id="step-subtitle-in_progress">
                                    @if($active3)
                                        <p class="text-[10px] lg:text-[11px] text-brand-primary bg-brand-secondary px-2 py-0.5 rounded font-bold mt-1 max-w-max">☕ Barista meracik pesananmu...</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Step 4: Siap Diambil (ready) --}}
                        @php $done4 = $currentIndex >= 3; $active4 = $order->status === 'ready'; @endphp
                        <div id="step-row-ready" class="relative flex items-start gap-4 lg:gap-6 {{ $active4 ? 'animate-pulse' : '' }}">
                            <div id="step-circle-ready" class="flex-shrink-0 w-8 h-8 lg:w-10 lg:h-10 rounded-full border-4 border-white {{ $done4 ? 'bg-green-500 shadow-sm shadow-green-500/30' : 'bg-slate-200' }} text-white flex items-center justify-center transition-colors duration-500">
                                @if($done4)
                                    <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-white opacity-50"></div>
                                @endif
                            </div>
                            <div class="pt-0.5 lg:pt-1">
                                <h4 id="step-title-ready" class="text-sm lg:text-base font-bold leading-tight {{ $done4 ? 'text-green-600' : 'text-slate-400' }}">Siap Diambil!</h4>
                                <div id="step-subtitle-ready">
                                    @if($active4)
                                        <p class="text-[10px] lg:text-[11px] text-green-700 bg-green-50 px-2 py-0.5 rounded font-bold mt-1 max-w-max">🎉 Pesanan Anda siap di kasir!</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Step 5: Selesai (completed) --}}
                        @php $done5 = $order->status === 'completed'; @endphp
                        <div id="step-row-completed" class="relative flex items-start gap-4 lg:gap-6">
                            <div id="step-circle-completed" class="flex-shrink-0 w-8 h-8 lg:w-10 lg:h-10 rounded-full border-4 border-white {{ $done5 ? 'bg-emerald-500 shadow-md shadow-emerald-500/20' : 'bg-slate-200' }} text-white flex items-center justify-center transition-colors duration-500">
                                @if($done5)
                                    <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-white opacity-50"></div>
                                @endif
                            </div>
                            <div class="pt-0.5 lg:pt-1">
                                <h4 id="step-title-completed" class="text-sm lg:text-base font-bold leading-tight {{ $done5 ? 'text-emerald-600' : 'text-slate-400' }}">Pesanan Selesai</h4>
                                <div id="step-subtitle-completed">
                                    @if($done5)
                                        <p class="text-[10px] lg:text-[11px] text-slate-500 font-medium mt-0.5">
                                            {{ $order->completed_at?->format('H:i') }} WIB — Terima kasih sudah memesan! 😊
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Step: Dibatalkan --}}
                        @if($order->status === 'cancelled')
                        <div class="relative flex items-start gap-4 lg:gap-6 mt-4">
                            <div class="flex-shrink-0 w-8 h-8 lg:w-10 lg:h-10 rounded-full border-4 border-white bg-red-500 text-white shadow-sm flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <div class="pt-0.5 lg:pt-1">
                                <h4 class="text-sm lg:text-base font-bold text-red-600 leading-tight">Dibatalkan</h4>
                                <p class="text-[10px] lg:text-[11px] text-slate-500 font-medium mt-1">
                                    {{ $order->cancel_reason ? 'Alasan: ' . $order->cancel_reason : 'Pesanan dibatalkan.' }}
                                </p>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>

            {{-- Kanan: Rincian Produk --}}

            <div class="xl:col-span-5 relative">
                <div class="sticky top-[88px] bg-white rounded-2xl md:rounded-3xl shadow-lg shadow-slate-900/5 border border-slate-100 overflow-hidden">
                    
                    {{-- Header Rincian --}}
                    <div class="p-5 md:p-6 pb-2 border-b border-dashed border-slate-200 bg-slate-50/50">
                        <div class="flex items-center justify-between mb-4" x-data>
                            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Rincian Item</p>
                            <div id="receipt-button-container" class="{{ $order->payment->status !== 'verified' ? 'hidden' : '' }}">
                                <button @click="$dispatch('open-receipt')" class="text-[10px] md:text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 px-3 py-1.5 rounded-lg inline-flex items-center gap-1.5 transition-all shadow-sm active:scale-95">
                                    <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Lihat & Download Struk
                                </button>
                            </div>
                        </div>
                        
                        <div class="space-y-4 max-h-[350px] overflow-y-auto no-scrollbar pb-4">
                            @foreach($order->items as $item)
                            <div class="flex flex-col gap-1">
                                <div class="flex justify-between items-start gap-4">
                                    <p class="text-sm font-bold text-slate-800 leading-snug">{{ $item->product_name }}</p>
                                    <p class="text-sm font-extrabold text-slate-800 whitespace-nowrap">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between items-center text-[11px] text-slate-500">
                                    <p>{{ $item->quantity }}x @ Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
                                </div>
                                @if($item->notes)
                                    <p class="text-[10px] bg-brand-secondary text-brand-primary font-medium px-2 py-1 rounded w-max mt-1 border border-brand-primary/10 italic line-clamp-1">"{{ $item->notes }}"</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Total Rincian --}}
                    <div class="p-5 md:p-6 bg-white">
                        <div class="flex justify-between items-center mb-1.5">
                            <p class="text-xs md:text-sm text-slate-500 font-medium">Subtotal</p>
                            <p class="text-sm font-bold text-slate-800 bg-slate-100 px-2 rounded">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-between items-center mb-5 border-b border-slate-100 pb-5">
                            <p class="text-[10px] text-slate-400 font-medium">Biaya Layanan/Lainnya</p>
                            <p class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 rounded">Bebas Biaya</p>
                        </div>

                        <div class="bg-slate-800 rounded-xl md:rounded-2xl p-4 md:p-5 flex justify-between items-center relative overflow-hidden">
                            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_2px_2px,white_1px,transparent_0)]" style="background-size: 16px 16px;"></div>
                            <span class="text-xs md:text-sm font-bold text-slate-300 relative z-10 uppercase tracking-widest">Total Bayar</span>
                            <span class="text-xl md:text-2xl font-black text-white tracking-tight relative z-10">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>

                        @if($order->status === 'completed' && !$order->reviews()->exists())
                            <div class="mt-4" x-data="{ showReviewModal: false }">
                                <div class="mt-4" x-data="{ showReviewModal: false }">
                                <button type="button" @click="showReviewModal = true" class="w-full bg-brand-primary hover:bg-brand-dark active:scale-[0.98] text-white font-bold py-3.5 px-4 rounded-xl text-xs md:text-sm transition-all flex items-center justify-center gap-2 shadow-md shadow-brand-primary/20">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Beri Penilaian Pesanan
                                </button>

                                {{-- Review Modal (using proper x-teleport template) --}}
                                <template x-teleport="body">
                                    <div x-show="showReviewModal" style="display:none;" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm" @click="showReviewModal = false"></div>
                                        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                            {{-- Header --}}
                                            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 bg-slate-50 shrink-0">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-brand-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <h3 class="font-bold text-slate-800 text-sm md:text-base">Penilaian Pesanan</h3>
                                                </div>
                                                <button type="button" aria-label="Tutup Modal Penilaian" @click="showReviewModal = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 hover:bg-slate-300 text-slate-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </div>

                                            {{-- Scrollable Body --}}
                                            <div class="overflow-y-auto p-5 space-y-1">
                                                <form action="{{ route('review.store') }}" method="POST" id="reviewForm">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <p class="text-xs md:text-sm text-slate-500 mb-4">Bagikan pengalaman Anda tentang menu yang dipesan. Penilaian Anda sangat berarti bagi kami! 😊</p>

                                                    <div class="space-y-4">
                                                        @foreach($order->items as $index => $item)
                                                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100" x-data="starRating(5)">
                                                                <input type="hidden" name="reviews[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                                                <input type="hidden" name="reviews[{{ $index }}][rating]" x-bind:value="selected">

                                                                {{-- Product Name --}}
                                                                <div class="flex items-center gap-2 mb-3">
                                                                    <div class="w-8 h-8 bg-brand-secondary rounded-lg flex items-center justify-center shrink-0">
                                                                        <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                                    </div>
                                                                    <h4 class="font-bold text-slate-800 text-sm">{{ $item->product_name }}</h4>
                                                                </div>

                                                                {{-- Star Rating --}}
                                                                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-2">Rating</p>
                                                                <div class="flex items-center gap-1.5 mb-1">
                                                                    <button type="button" aria-label="Rating 1 Bintang" @click="setRating(1)" @mouseenter="hovered=1" @mouseleave="hovered=0" class="focus:outline-none transition-transform hover:scale-110">
                                                                        <svg class="w-8 h-8" :class="(hovered||selected)>=1?'text-brand-primary':'text-slate-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                                    </button>
                                                                    <button type="button" aria-label="Rating 2 Bintang" @click="setRating(2)" @mouseenter="hovered=2" @mouseleave="hovered=0" class="focus:outline-none transition-transform hover:scale-110">
                                                                        <svg class="w-8 h-8" :class="(hovered||selected)>=2?'text-brand-primary':'text-slate-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                                    </button>
                                                                    <button type="button" aria-label="Rating 3 Bintang" @click="setRating(3)" @mouseenter="hovered=3" @mouseleave="hovered=0" class="focus:outline-none transition-transform hover:scale-110">
                                                                        <svg class="w-8 h-8" :class="(hovered||selected)>=3?'text-brand-primary':'text-slate-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                                    </button>
                                                                    <button type="button" aria-label="Rating 4 Bintang" @click="setRating(4)" @mouseenter="hovered=4" @mouseleave="hovered=0" class="focus:outline-none transition-transform hover:scale-110">
                                                                        <svg class="w-8 h-8" :class="(hovered||selected)>=4?'text-brand-primary':'text-slate-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                                    </button>
                                                                    <button type="button" aria-label="Rating 5 Bintang" @click="setRating(5)" @mouseenter="hovered=5" @mouseleave="hovered=0" class="focus:outline-none transition-transform hover:scale-110">
                                                                        <svg class="w-8 h-8" :class="(hovered||selected)>=5?'text-brand-primary':'text-slate-200'" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                                    </button>
                                                                </div>
                                                                <p class="text-xs font-semibold text-brand-primary" x-text="['','Sangat Buruk','Buruk','Cukup','Bagus','Sangat Bagus'][selected]"></p>

                                                                {{-- Komentar --}}
                                                                <div class="mt-3">
                                                                    <label for="review-comment-{{ $index }}" class="block text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Komentar (Opsional)</label>
                                                                    <textarea id="review-comment-{{ $index }}" name="reviews[{{ $index }}][comment]" rows="2" class="w-full text-xs md:text-sm bg-white border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/20 transition-all placeholder:text-slate-300 resize-none" placeholder="Ceritakan pengalaman rasa..."></textarea>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- Footer Buttons --}}
                                                    <div class="mt-5 flex gap-3">
                                                        <button type="button" @click="showReviewModal = false" class="flex-1 py-3 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold transition-colors">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="flex-1 py-3 px-4 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold transition-colors shadow-md shadow-brand-primary/25">
                                                            ✨ Kirim Penilaian
                                                        </button>
                                                    </div>
                                                </form>
                                                                         </div>
                                    </div>
                                </template>
                            </div>
                        @else
                            @if($order->status === 'completed' && $order->reviews()->exists())
                            <div class="mt-4 bg-emerald-50 border border-emerald-100 rounded-xl md:rounded-2xl p-4 text-center">
                                <p class="text-xs md:text-sm text-emerald-700 font-bold mb-1">Terima kasih atas penilaian Anda!</p>
                                <p class="text-[10px] md:text-[11px] text-emerald-600">Review Anda sangat membantu pelayanan kami.</p>
                            </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Thermal Receipt Modal --}}
    <div x-data="{ 
            showReceiptModal: false,
            isDownloading: false,
            downloadReceipt() {
                this.isDownloading = true;
                const receiptElement = document.getElementById('thermal-receipt-capture');
                
                // HTML2Canvas needs the element to be visible and un-transformed 
                // We're capturing it right as it is inside the modal
                html2canvas(receiptElement, {
                    scale: 2, // Higher resolution
                    backgroundColor: '#fdfbf7',
                    logging: false,
                    useCORS: true
                }).then(canvas => {
                    // Convert to image
                    const image = canvas.toDataURL('image/png', 1.0);
                    
                    // Create download link
                    const link = document.createElement('a');
                    link.download = `Struk_{{ $order->order_code }}.png`;
                    link.href = image;
                    link.click();
                    
                    this.isDownloading = false;
                }).catch(err => {
                    console.error('Error generating receipt:', err);
                    alert('Gagal mendownload struk. Silakan coba lagi.');
                    this.isDownloading = false;
                });
            }
         }" 
         x-show="showReceiptModal" 
         @open-receipt.window="showReceiptModal = true"
         style="display:none;" 
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
         
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm" x-transition.opacity @click="showReceiptModal = false"></div>
        
        <div class="relative w-full max-w-sm flex flex-col gap-4" 
             x-show="showReceiptModal"
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-8 scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
             x-transition:leave-end="opacity-0 translate-y-8 scale-95">
             
            {{-- Close Button for Modal --}}
            <div class="flex justify-between items-center bg-white rounded-xl p-3 shadow-lg px-4">
                <h3 class="font-bold text-slate-800 text-sm">Struk #{{ $order->order_code }}</h3>
                <button type="button" aria-label="Tutup Struk" @click="showReceiptModal = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Exact Thermal Receipt Layout --}}
            <div class="relative w-full mx-auto max-h-[70vh] overflow-y-auto no-scrollbar rounded-lg" style="box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <div id="thermal-receipt-capture" class="bg-[#fdfbf7] border border-slate-200" style="font-family: 'Courier New', Courier, monospace; position: relative;">
                    
                    {{-- Zig-zag top edge --}}
                    <div style="height: 12px; background: linear-gradient(-45deg, transparent 9px, transparent 0), linear-gradient(45deg, transparent 9px, #fdfbf7 0); background-repeat: repeat-x; background-size: 12px 12px; background-position: left bottom; position: absolute; top: -12px; left: 0; right: 0;"></div>
                    
                    {{-- Receipt Content --}}
                    <div class="px-5 md:px-7 pt-8 pb-5 flex flex-col items-center">
                        <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight uppercase text-center mb-1">{{ \App\Models\Setting::get('shop_name', 'Coffee Shop') }}</h2>
                        <p class="text-xs text-slate-600 text-center max-w-[200px] leading-tight mb-4">
                            Struk Pemesanan<br>
                            Terima Kasih Atas Kunjungan Anda
                        </p>
                        
                        <div class="w-full border-t border-dashed border-slate-400 my-4"></div>
                        
                        <div class="w-full flex justify-between text-xs text-slate-600 mb-1">
                            <span>WAKTU</span>
                            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="w-full flex justify-between text-xs text-slate-600 mb-1">
                            <span>KASIR</span>
                            <span>Toko Online</span>
                        </div>
                        <div class="w-full flex justify-between text-xs text-slate-600 mb-1">
                            <span>ORDER ID</span>
                            <span>{{ $order->order_code }}</span>
                        </div>
                        <div class="w-full flex justify-between text-xs text-slate-600 mb-4">
                            <span>PELANGGAN</span>
                            <span class="text-right truncate max-w-[150px]">{{ $order->customer_name }}</span>
                        </div>

                        <div class="w-full border-t border-dashed border-slate-400 mb-4"></div>

                        {{-- Order Items --}}
                        <div class="w-full space-y-3 pb-2 pr-1">
                            @foreach($order->items as $item)
                            <div class="flex flex-col">
                                <p class="text-[13px] font-bold text-slate-800 uppercase leading-snug">{{ $item->product_name }}</p>
                                <div class="flex justify-between items-start mt-0.5" style="page-break-inside: avoid;">
                                    <p class="text-xs text-slate-600">{{ $item->quantity }} x {{ number_format($item->product_price, 0, ',', '.') }}</p>
                                    <p class="text-[13px] font-bold text-slate-900">{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                                @if($item->notes)
                                    <p class="text-[11px] text-slate-500 italic mt-0.5 ml-2 border-l border-slate-300 pl-2">Catatan: {{ $item->notes }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <div class="w-full border-t border-dashed border-slate-400 mt-2 mb-4"></div>

                        {{-- Totals --}}
                        <div class="w-full space-y-1.5 mb-5" style="page-break-inside: avoid;">
                            <div class="flex justify-between items-center">
                                <p class="text-xs text-slate-600 uppercase">Subtotal</p>
                                <p class="text-xs font-bold text-slate-800">{{ number_format($order->subtotal, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-xs text-slate-600 uppercase">Biaya Layanan</p>
                                <p class="text-xs font-bold text-slate-800">RP 0</p>
                            </div>
                            <div class="w-full flex justify-between items-center mt-3 pt-3 border-t border-slate-400">
                                <p class="text-sm font-black text-slate-900 uppercase tracking-widest">Total</p>
                                <p class="text-base font-black text-slate-900 bg-slate-200 px-1.5 py-0.5 rounded-sm">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <p class="text-[11px] text-slate-500 uppercase">Tipe Bayar</p>
                                <p class="text-[11px] font-bold text-slate-800 uppercase">{{ $order->payment->method }}</p>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-[11px] text-slate-500 uppercase">Status</p>
                                <p id="receipt-payment-status" class="text-[11px] font-bold text-slate-800 uppercase">{{ $order->payment->status === 'verified' ? 'LUNAS' : ($order->payment->status === 'rejected' ? 'DITOLAK' : 'BELUM LUNAS') }}</p>
                            </div>
                        </div>
                        
                        {{-- Barcode Simulation --}}
                        <div class="w-full mt-4 flex flex-col items-center pb-2">
                            <div class="h-10 w-[80%] flex justify-between" style="background: repeating-linear-gradient(to right, #0f172a, #0f172a 2px, transparent 2px, transparent 5px, #0f172a 5px, #0f172a 6px, transparent 6px, transparent 8px, #0f172a 8px, #0f172a 12px, transparent 12px, transparent 15px);"></div>
                            <p class="text-[10px] font-mono text-slate-500 mt-1 tracking-[0.2em]">{{ $order->order_code }}</p>
                        </div>

                    </div>
                    
                    {{-- Zig-zag bottom edge --}}
                    <div style="height: 12px; background: linear-gradient(-45deg, #fdfbf7 9px, transparent 0), linear-gradient(45deg, #fdfbf7 9px, transparent 0); background-repeat: repeat-x; background-size: 12px 12px; background-position: left top; position: absolute; bottom: -12px; left: 0; right: 0;"></div>
                </div>
            </div>

            <button @click="downloadReceipt()" :disabled="isDownloading" class="w-full bg-slate-800 hover:bg-slate-900 active:scale-[0.98] text-white font-bold py-3.5 px-4 rounded-xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg disabled:opacity-75 disabled:cursor-wait">
                <template x-if="!isDownloading">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </template>
                <template x-if="isDownloading">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </template>
                <span x-text="isDownloading ? 'Menyiapkan Gambar...' : 'Download Struk PNG'"></span>
            </button>
        </div>
    </div>

    {{-- ============================================================
         Scripts — diletakkan di dalam slot agar dirender oleh layout
         ============================================================ --}}

    {{-- HTML2Canvas untuk fitur download struk --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
    function starRating(initial) {
        return {
            selected: initial,
            hovered: 0,
            setRating(val) { this.selected = val; }
        };
    }
    </script>

    @push('scripts')
    {{-- Realtime Order Tracker — inisialisasi setelah Vite bundle dimuat --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var attempts = 0;
            var maxAttempts = 50; // 50 * 100ms = 5 detik menunggu
            
            var trackerInterval = setInterval(function() {
                if (typeof window.initOrderTracker === 'function') {
                    clearInterval(trackerInterval);
                    console.log("Tracker JS berhasil dimuat pada percobaan ke-" + attempts);
                    window.initOrderTracker('{{ $order->order_code }}');
                } else {
                    attempts++;
                    if (attempts >= maxAttempts) {
                        clearInterval(trackerInterval);
                        alert("File Javascript Vite (App.js) gagal dieksekusi oleh Chrome Android Anda (Mungkin tidak disupport koneksi LAN non-HTTPS).");
                    }
                }
            }, 100);
        });
    </script>
    @endpush

</x-layouts.app>
