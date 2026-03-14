<x-layouts.app title="Pesanan Gagal">

    <div class="px-4 py-8 md:px-10 md:py-16 max-w-2xl mx-auto text-center">
        
        {{-- Ikon Error --}}
        <div class="w-20 h-20 md:w-28 md:h-28 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 md:mb-6 shadow-inner">
            <svg class="w-10 h-10 md:w-14 md:h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>

        {{-- Pesan Utama --}}
        <h1 class="text-xl md:text-3xl font-extrabold text-slate-800 mb-2 md:mb-3">Mohon Maaf, Pesanan Gagal Diproses</h1>
        
        <div class="bg-red-50 border border-red-100 rounded-xl md:rounded-2xl p-4 md:p-5 mb-6 md:mb-8 inline-block text-left w-full shadow-sm">
            <p class="text-xs md:text-base text-red-700 font-medium">Alasan kegagalan:</p>
            <p class="text-sm md:text-lg font-bold text-red-800 mt-0.5 md:mt-1">{{ $errorMessage }}</p>
        </div>

        {{-- Menampilkan ulang cart yang gagal (opsional) --}}
        @if(!empty($failedCart))
        <div class="text-left bg-white rounded-2xl md:rounded-3xl border border-slate-100 p-4 md:p-6 mb-6 md:mb-8 shadow-sm">
            <h2 class="text-xs md:text-sm font-bold text-slate-500 uppercase tracking-widest mb-3 md:mb-4">Keranjang Anda Sebelumnya</h2>
            <div class="space-y-2.5 md:space-y-3">
                @foreach($failedCart as $item)
                <div class="flex justify-between items-center py-2 border-b border-dashed border-slate-100 last:border-0 last:pb-0">
                    <div class="flex-1 pr-3 md:pr-4">
                        <p class="text-xs md:text-sm font-bold text-slate-800">{{ $item['name'] }}</p>
                        <p class="text-[10px] md:text-xs text-slate-500">{{ $item['quantity'] }}x @ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <p class="text-[9px] md:text-[11px] text-slate-400 mt-3 md:mt-4 italic">*Stok mungkin telah habis atau sistem sedang sibuk. Silakan coba atur ulang pesanan Anda.</p>
        </div>
        @endif

        {{-- Call to Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
            <a href="{{ route('menu.index') }}" class="inline-flex justify-center items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-bold py-3.5 md:py-4 px-6 md:px-8 rounded-xl md:rounded-2xl text-sm md:text-base shadow-lg shadow-amber-600/30 transition-all active:scale-[0.98]">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Menu
            </a>
            
            @if($whatsappAdmin)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsappAdmin) }}?text=Halo%20Admin,%20saya%20mengalami%20kendala%20saat%20membuat%20pesanan%20di%20website" target="_blank" class="inline-flex justify-center items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-3.5 md:py-4 px-6 md:px-8 rounded-xl md:rounded-2xl text-sm md:text-base shadow-sm transition-all">
                <svg class="w-4 h-4 md:w-5 md:h-5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12c0 1.74.45 3.37 1.23 4.81L2 22l5.19-1.23C8.63 21.55 10.26 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zM9 10a1 1 0 100-2 1 1 0 000 2zm3-1a1 1 0 11-2 0 1 1 0 012 0zm5 1a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                Hubungi Admin
            </a>
            @endif
        </div>

    </div>
</x-layouts.app>
