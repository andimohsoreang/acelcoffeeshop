<x-layouts.app title="Pesanan Berhasil">

    <div class="px-4 py-6 md:px-10 md:py-12 max-w-3xl mx-auto">
        
        {{-- Status Header --}}
        <div class="text-center mb-6 md:mb-8">
            <div class="w-16 h-16 md:w-24 md:h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-5 shadow-inner">
                <svg class="w-8 h-8 md:w-12 md:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-xl md:text-3xl font-extrabold text-slate-800 mb-1.5 md:mb-2">Pesanan Berhasil!</h1>
            <p class="text-xs md:text-base text-slate-500">Terima kasih, pesanan Anda sedang kami terima.</p>
        </div>

        {{-- Nomor Antrean & Kode Pesanan --}}
        <div class="bg-white rounded-2xl md:rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-5 md:mb-6">
            <div class="bg-amber-500 px-4 py-3 md:px-6 md:py-4 text-center">
                <p class="text-amber-100 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-0.5 md:mb-1">Nomor Antrean Anda</p>
                <div class="text-3xl md:text-5xl font-black text-white tracking-tight">{{ $order->queue_number }}</div>
            </div>
            
            <div class="p-4 md:p-6">
                <div class="flex flex-wrap items-center justify-between gap-3 md:gap-4 mb-4 pb-4 border-b border-dashed border-slate-200">
                    <div>
                        <p class="text-[9px] md:text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5 md:mb-1">Kode Pesanan</p>
                        <p class="text-sm md:text-base font-bold text-slate-800">{{ $order->order_code }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] md:text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5 md:mb-1">Total Tagihan</p>
                        <p class="text-base md:text-lg font-black text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-y-3 gap-x-4 md:gap-y-4 md:gap-x-6">
                    <div>
                        <p class="text-[9px] md:text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5 md:mb-1">Tipe</p>
                        <p class="text-xs md:text-sm font-bold text-slate-800">
                            @if($order->order_type === 'dine_in')
                                Dine In (Meja {{ $order->table_number }})
                            @else
                                Takeaway
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-[9px] md:text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5 md:mb-1">Pemesan</p>
                        <p class="text-xs md:text-sm font-bold text-slate-800 truncate">{{ $order->customer_name }}</p>
                        <p class="text-[10px] md:text-xs text-slate-500">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] md:text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5 md:mb-1">Pembayaran</p>
                        @if($order->payment->status === 'verified')
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-[9px] md:text-[10px] font-bold px-1.5 md:px-2 py-0.5 md:py-1 rounded md:rounded-md uppercase">
                                <svg class="w-2.5 h-2.5 md:w-3 md:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Lunas
                            </span>
                        @elseif($order->payment->status === 'uploaded')
                            <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-[9px] md:text-[10px] font-bold px-1.5 md:px-2 py-0.5 md:py-1 rounded md:rounded-md uppercase">
                                <svg class="w-2.5 h-2.5 md:w-3 md:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Menunggu
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-[9px] md:text-[10px] font-bold px-1.5 md:px-2 py-0.5 md:py-1 rounded md:rounded-md uppercase">
                                <svg class="w-2.5 h-2.5 md:w-3 md:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Belum
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-[9px] md:text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-0.5 md:mb-1">Status</p>
                        <span class="text-xs md:text-sm font-bold text-slate-800 capitalize">{{ $order->status }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instruksi Pembayaran & Upload Bukti (Hanya jika belum verified & bukan cash) --}}
        @if($order->payment->method !== 'cash' && $order->payment->status === 'pending')
            <div class="bg-blue-50/50 rounded-2xl md:rounded-3xl border border-blue-100 p-4 md:p-6 mb-5 md:mb-6">
                <h3 class="text-xs md:text-sm font-bold text-blue-800 mb-3 md:mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Instruksi Pembayaran {{ ucfirst($order->payment->method) }}
                </h3>

                @if($order->payment->method === 'transfer')
                    @php $banks = \App\Models\BankAccount::active()->get(); @endphp
                    <div class="bg-white rounded-xl md:rounded-2xl p-3 md:p-4 border border-blue-100 mb-4 md:mb-5 text-[11px] md:text-sm">
                        <p class="text-slate-600 mb-2 md:mb-3">Silakan transfer nominal <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> ke salah satu rekening:</p>
                        <div class="space-y-2.5 md:space-y-3">
                            @foreach($banks as $bank)
                                <div class="p-2.5 md:p-3 bg-slate-50 rounded-lg md:rounded-xl border border-slate-100">
                                    <p class="font-bold text-slate-800 text-sm md:text-base uppercase">{{ $bank->bank_name }}</p>
                                    <p class="font-mono text-base md:text-lg text-emerald-600 tracking-wider my-0.5 md:my-1">{{ $bank->account_number }}</p>
                                    <p class="text-[10px] md:text-xs text-slate-500">a.n. {{ $bank->account_name }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                
                @elseif($order->payment->method === 'qris')
                    @php $qris = \App\Models\QrisSetting::getActive(); @endphp
                    @if($qris && $qris->image)
                        <div class="bg-white rounded-xl md:rounded-2xl p-3 md:p-4 border border-blue-100 mb-4 md:mb-5 text-center">
                            <p class="text-slate-600 text-xs md:text-sm mb-3 md:mb-4">Scan QRIS di bawah ini untuk membayar sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                            
                            {{-- QRIS Image Layout with Modal Trigger & Download --}}
                            <div x-data="{ showQrisModal: false }" class="inline-block relative">
                                <img @click="showQrisModal = true" src="{{ asset('storage/' . $qris->image) }}" alt="QRIS" loading="lazy" width="250" height="250" class="w-48 h-48 md:w-64 md:h-64 object-contain mx-auto rounded-lg md:rounded-xl border border-slate-100 p-1.5 md:p-2 shadow-sm cursor-pointer hover:border-amber-300 transition-colors">
                                
                                <div class="mt-3 flex items-center justify-center gap-2">
                                    <button @click="showQrisModal = true" type="button" class="inline-flex items-center gap-1.5 text-[10px] md:text-xs font-bold text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                        Perbesar
                                    </button>
                                    <a href="{{ asset('storage/' . $qris->image) }}" download="QRIS_{{ Str::slug($qris->merchant_name) }}.png" class="inline-flex items-center gap-1.5 text-[10px] md:text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        Simpan QR
                                    </a>
                                </div>
                                
                                {{-- QRIS Preview Modal --}}
                                <div x-show="showQrisModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4" x-transition.opacity>
                                    <div @click.away="showQrisModal = false" class="bg-white rounded-2xl md:rounded-3xl shadow-2xl overflow-hidden max-w-sm w-full relative transform transition-all" x-show="showQrisModal" x-transition.scale.95>
                                        <div class="p-4 md:p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                            <h3 class="font-bold text-slate-800 text-sm md:text-base">Scan QRIS</h3>
                                            <button @click="showQrisModal = false" aria-label="Tutup Banner QRIS" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 text-slate-500 hover:bg-slate-300 hover:text-slate-700 transition-colors">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 md:p-8 bg-white flex flex-col items-center">
                                            <img src="{{ asset('storage/' . $qris->image) }}" alt="QRIS Besar" loading="lazy" class="w-full max-w-[250px] md:max-w-[300px] h-auto object-contain mb-4">
                                            <p class="font-bold text-slate-800 text-sm md:text-base text-center">{{ $qris->merchant_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-[10px] md:text-xs font-bold text-slate-800 mt-2 md:mt-3">{{ $qris->merchant_name }}</p>
                        </div>
                    @endif
                @endif

                {{-- Menunggu Konfirmasi Admin --}}
                <div class="flex items-center gap-2.5 bg-blue-50 border border-blue-100 rounded-xl p-3.5 mt-2">
                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <p class="text-[11px] md:text-xs text-blue-700 font-medium">Tidak perlu kirim bukti. Admin akan memverifikasi pembayaran Anda secara otomatis.</p>
                </div>
            </div>
        @elseif($order->payment->method === 'cash')
            <div class="bg-amber-50 rounded-2xl md:rounded-3xl border border-amber-100 p-4 md:p-5 mb-5 md:mb-6 text-center">
                <svg class="w-6 h-6 md:w-8 md:h-8 text-amber-500 mx-auto mb-1.5 md:mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p class="text-xs md:text-sm text-slate-800 font-bold mb-0.5 md:mb-1">Pembayaran Tunai Kasir</p>
                <p class="text-[10px] md:text-xs text-slate-500">Sebutkan <strong>Nomor Antrean</strong> Anda saat di kasir.</p>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-2 md:gap-3">
            <a href="{{ route('order.show', $order->order_code) }}" class="flex-1 text-center bg-white border-2 border-amber-500 text-amber-600 hover:bg-amber-50 font-bold py-3 md:py-3.5 px-4 rounded-xl md:rounded-2xl text-xs md:text-sm transition-colors">
                Lacak Status Pesanan
            </a>
            <a href="{{ route('home') }}" class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 md:py-3.5 px-4 rounded-xl md:rounded-2xl text-xs md:text-sm transition-colors">
                Kembali ke Beranda
            </a>
        </div>
        
    </div>
</x-layouts.app>
