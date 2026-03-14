<x-layouts.app title="Riwayat Pesanan Saya">

    {{-- Mobile Header --}}
    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 py-3 md:hidden">
        <h1 class="text-base font-extrabold text-slate-800 text-center">Riwayat Pesanan</h1>
    </div>

    {{-- Desktop Header --}}
    <div class="hidden md:flex items-center gap-4 px-6 lg:px-10 py-6 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Riwayat Pesanan</h1>
            <p class="text-sm text-slate-500">Lacak dan lihat semua pesanan Anda sebelumnya.</p>
        </div>
    </div>

    <div class="px-4 py-5 md:px-6 lg:px-10 max-w-4xl mx-auto min-h-[60vh]">
        
        {{-- Search Form --}}
        <div class="bg-white rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border border-slate-100 mb-5 md:mb-6">
            <h2 class="text-xs md:text-sm font-bold text-slate-800 mb-2.5 md:mb-3">Cari Pesanan dengan Nomor WhatsApp</h2>
            <form action="{{ route('order.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 md:gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 md:pl-4 pointer-events-none">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <input type="tel" name="phone" value="{{ request('phone') }}" required aria-label="Masukkan Nomor WhatsApp Anda"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs md:text-sm rounded-xl md:rounded-2xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 pl-10 md:p-4 md:pl-12 transition-colors"
                           placeholder="Contoh: 081234567890">
                </div>
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3.5 px-5 md:py-4 md:px-6 rounded-xl md:rounded-2xl text-xs md:text-sm transition-colors flex items-center justify-center gap-2 flex-shrink-0">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Pesanan
                </button>
            </form>
            <p class="text-[10px] md:text-[11px] text-slate-500 mt-2.5 md:mt-3">*Masukkan nomor yang Anda gunakan saat checkout untuk melihat riwayat.</p>
        </div>

        {{-- Hasil Pencarian --}}
        @if(!$searched)
            {{-- State Awal (Belum Mencari) --}}
            <div class="text-center py-12 md:py-16 bg-white/50 border border-dashed border-slate-200 rounded-2xl md:rounded-3xl">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-base md:text-lg font-bold text-slate-600 mb-1">Cari Riwayat Pesanan Anda</h3>
                <p class="text-xs md:text-sm text-slate-400 max-w-xs mx-auto">Kami meminimalisir akun, kami menyimpan semua riwayat transaksi berdasarkan nomor WhatsApp Anda.</p>
            </div>
        @else
            @if($orders->count() > 0)
                {{-- Daftar Pesanan --}}
                <div class="space-y-3.5 md:space-y-4 relative">
                    <h3 class="text-xs md:text-sm font-bold text-slate-500 uppercase tracking-widest pl-1 mb-1.5 md:mb-2">Riwayat untuk {{ $phone }}</h3>
                    
                    @foreach($orders as $order)
                        <a href="{{ route('order.show', $order->order_code) }}" aria-label="Lihat detail pesanan {{ $order->order_code }}" class="block bg-white rounded-xl md:rounded-2xl p-3.5 md:p-5 border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all group">
                            <div class="flex items-start justify-between mb-2.5 md:mb-3 border-b border-dashed border-slate-100 pb-2.5 md:pb-3">
                                <div>
                                    <p class="text-[9px] md:text-[10px] text-slate-400 font-semibold mb-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    <p class="text-xs md:text-sm font-bold text-slate-800">{{ $order->order_code }}</p>
                                </div>
                                <div class="text-right">
                                    {{-- Status Badge --}}
                                    @if($order->status === 'pending')
                                        <span class="inline-flex bg-amber-100 text-amber-700 text-[9px] md:text-[10px] font-bold px-1.5 md:px-2 py-0.5 md:py-1 rounded border border-amber-200">Menunggu</span>
                                    @elseif($order->status === 'processing')
                                        <span class="inline-flex bg-blue-100 text-blue-700 text-[9px] md:text-[10px] font-bold px-1.5 md:px-2 py-0.5 md:py-1 rounded border border-blue-200">Diproses</span>
                                    @elseif($order->status === 'completed')
                                        <span class="inline-flex bg-green-100 text-green-700 text-[9px] md:text-[10px] font-bold px-1.5 md:px-2 py-0.5 md:py-1 rounded border border-green-200">Selesai</span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="inline-flex bg-red-100 text-red-700 text-[9px] md:text-[10px] font-bold px-1.5 md:px-2 py-0.5 md:py-1 rounded border border-red-200">Dibatalkan</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-[10px] md:text-xs text-slate-500 mb-0.5">Total ({{ $order->items->sum('quantity') }} item)</p>
                                    <p class="text-sm md:text-base font-black text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="w-7 h-7 md:w-8 md:h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-amber-50 group-hover:text-amber-500 transition-colors">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $orders->appends(['phone' => request('phone')])->links() }}
                </div>
                
            @else
                {{-- Kosong --}}
                <div class="text-center py-12 md:py-16 bg-white rounded-2xl md:rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-red-50 text-red-300 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-slate-800 mb-1">Pesanan Tidak Ditemukan</h3>
                    <p class="text-xs md:text-sm text-slate-500 max-w-xs mx-auto mb-4 md:mb-6">Kami tidak menemukan riwayat untuk nomor <strong>{{ $phone }}</strong>.</p>
                    <a href="{{ route('menu.index') }}" class="inline-flex justify-center items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-5 md:px-6 rounded-xl text-xs md:text-sm transition-colors">
                        Kembali ke Menu
                    </a>
                </div>
            @endif
        @endif

    </div>
</x-layouts.app>
