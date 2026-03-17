<x-layouts.app title="Checkout Pesanan">

    {{-- Header / Sticky Nav for Mobile --}}
    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 py-3 flex items-center gap-3 md:hidden">
        <a href="{{ route('cart.index') }}" aria-label="Kembali ke keranjang belanja" class="w-7 h-7 flex items-center justify-center rounded-full bg-slate-50 text-slate-500 active:bg-slate-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-base font-extrabold text-slate-800">Checkout</h1>
    </div>

    {{-- Desktop Header --}}
    <div class="hidden md:flex items-center gap-4 px-6 lg:px-10 py-5 border-b border-slate-100">
        <a href="{{ route('cart.index') }}" aria-label="Kembali ke keranjang belanja" class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-50 text-slate-500 hover:bg-slate-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Selesaikan Pesanan</h1>
            <p class="text-xs text-slate-500">Isi data pengiriman dan pembayaran di bawah ini</p>
        </div>
    </div>

    <div class="px-5 py-6 md:px-6 lg:px-10 relative">
        <form action="{{ route('checkout.store') }}" method="POST" x-data="{ orderType: '{{ old('order_type', 'takeaway') }}', paymentMethod: '{{ old('payment_method', 'cash') }}' }">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">
                
                {{-- Kiri: Form Data Diri & Pengiriman --}}
                <div class="lg:col-span-7 space-y-4 md:space-y-6">
                    
                    {{-- 1. Tipe Pemesanan --}}
                    <section class="bg-white rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border border-slate-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-brand-primary"></div>
                        <h2 class="text-sm md:text-base font-bold text-brand-dark mb-3 md:mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-brand-secondary text-brand-primary flex items-center justify-center text-xs md:text-sm border border-brand-primary/10">1</span>
                            Tipe Pemesanan
                        </h2>
                        
                        <div class="space-y-3">
                            {{-- Takeaway --}}
                            <label class="relative flex items-center p-3 md:p-4 gap-3 md:gap-4 cursor-pointer rounded-xl md:rounded-2xl border-2 transition-colors group"
                                   :class="orderType === 'takeaway' ? 'border-brand-primary bg-brand-secondary' : 'border-slate-100 hover:bg-slate-50'">
                                <div class="flex items-center shrink-0 pl-1 md:pl-2">
                                    <input name="order_type" type="radio" value="takeaway" x-model="orderType" class="w-5 h-5 text-brand-primary bg-slate-100 border-slate-300 focus:ring-brand-primary">
                                </div>
                                <div class="flex-1 flex items-center gap-3 md:gap-4">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-brand-secondary text-brand-primary flex items-center justify-center shrink-0 shadow-sm border border-brand-primary/10">
                                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm md:text-base font-bold text-slate-800">Bawa Pulang (Takeaway)</span>
                                    </div>
                                </div>
                            </label>

                            {{-- Dine In --}}
                            <label class="relative flex items-center p-3 md:p-4 gap-3 md:gap-4 cursor-pointer rounded-xl md:rounded-2xl border-2 transition-colors group"
                                   :class="orderType === 'dine_in' ? 'border-brand-primary bg-brand-secondary' : 'border-slate-100 hover:bg-slate-50'">
                                <div class="flex items-center shrink-0 pl-1 md:pl-2">
                                    <input name="order_type" type="radio" value="dine_in" x-model="orderType" class="w-5 h-5 text-brand-primary bg-slate-100 border-slate-300 focus:ring-brand-primary">
                                </div>
                                <div class="flex-1 flex items-center gap-3 md:gap-4">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-brand-secondary text-brand-primary flex items-center justify-center shrink-0 shadow-sm border border-brand-primary/10">
                                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm md:text-base font-bold text-slate-800">Makan di Tempat (Dine In)</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('order_type') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

                    </section>

                    {{-- 2. Data Pelanggan --}}
                    <section class="bg-white rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border border-slate-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-brand-primary"></div>
                        <h2 class="text-sm md:text-base font-bold text-brand-dark mb-3 md:mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-brand-secondary text-brand-primary flex items-center justify-center text-xs md:text-sm border border-brand-primary/10">2</span>
                            Data Pemesan
                        </h2>

                        <div class="space-y-3 md:space-y-4">
                            <div>
                                <label for="customer_name" class="block text-[11px] md:text-xs font-bold text-slate-600 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user() ? auth()->user()->name : '') }}" required
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs md:text-sm rounded-[10px] focus:ring-brand-primary focus:border-brand-primary block p-2.5 transition-colors"
                                       placeholder="Tulis namamu disini">
                                @error('customer_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-[11px] md:text-xs font-bold text-slate-600 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-slate-400 text-[11px] md:text-xs font-semibold">+62</span>
                                    </div>
                                    <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                                           class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs md:text-sm rounded-[10px] focus:ring-brand-primary focus:border-brand-primary block p-2.5 pl-10 transition-colors"
                                           placeholder="81234567890">
                                </div>
                                @error('customer_phone') <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                <p class="text-[9px] md:text-[10px] text-slate-500 mt-1">*Digunakan untuk melacak pesanan.</p>
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-[11px] md:text-xs font-bold text-slate-600 mb-1">Catatan Pesanan (Opsional)</label>
                                <textarea id="notes" name="notes" rows="2"
                                          class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs md:text-sm rounded-[10px] focus:ring-brand-primary focus:border-brand-primary block p-2.5 transition-colors"
                                          placeholder="Contoh: Es dipisah, dll">{{ old('notes') }}</textarea>
                                @error('notes') <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </section>

                    {{-- 3. Metode Pembayaran --}}
                    <section class="bg-white rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border border-slate-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-brand-primary"></div>
                        <h2 class="text-sm md:text-base font-bold text-brand-dark mb-3 md:mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-brand-secondary text-brand-primary flex items-center justify-center text-xs md:text-sm border border-brand-primary/10">3</span>
                            Metode Pembayaran
                        </h2>

                        <div class="space-y-3">
                            {{-- Cash --}}
                            <label class="relative flex items-center p-3 md:p-4 gap-3 md:gap-4 cursor-pointer rounded-xl md:rounded-2xl border-2 transition-colors group"
                                   :class="paymentMethod === 'cash' ? 'border-brand-primary bg-brand-secondary' : 'border-slate-100 hover:bg-slate-50'">
                                <div class="flex items-center shrink-0 pl-1 md:pl-2">
                                    <input name="payment_method" type="radio" value="cash" x-model="paymentMethod" class="w-5 h-5 text-brand-primary bg-slate-100 border-slate-300 focus:ring-brand-primary">
                                </div>
                                <div class="flex-1 flex items-center gap-3 md:gap-4">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center shrink-0 shadow-sm border border-green-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm md:text-base font-bold text-slate-800">Bayar di Kasir (Tunai/Debit)</span>
                                    </div>
                                </div>
                            </label>

                            {{-- QRIS --}}
                            {{-- QRIS --}}
                            @if(isset($hasQris) && $hasQris)
                            <label class="relative flex items-center p-3 md:p-4 gap-3 md:gap-4 cursor-pointer rounded-xl md:rounded-2xl border-2 transition-colors group"
                                   :class="paymentMethod === 'qris' ? 'border-brand-primary bg-brand-secondary' : 'border-slate-100 hover:bg-slate-50'">
                                <div class="flex items-center shrink-0 pl-1 md:pl-2">
                                    <input name="payment_method" type="radio" value="qris" x-model="paymentMethod" class="w-5 h-5 text-brand-primary bg-slate-100 border-slate-300 focus:ring-brand-primary">
                                </div>
                                <div class="flex-1 flex items-center gap-3 md:gap-4">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0 shadow-sm border border-purple-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm md:text-base font-bold text-slate-800">QRIS (OVO, Dana, dll)</span>
                                    </div>
                                </div>
                            </label>
                            @endif
                        </div>
                        @error('payment_method') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </section>

                </div>

                {{-- Kanan: Ringkasan Pesanan --}}
                <div class="lg:col-span-5 relative mt-2 lg:mt-0">
                    <div class="sticky top-20 bg-white rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-xl shadow-brand-dark/5 border border-brand-primary/10 overflow-hidden">
                        {{-- Decorative gradient background --}}
                        <div class="absolute inset-0 bg-brand-secondary/30 pointer-events-none"></div>

                        <div class="relative z-10">
                            <h2 class="text-xs md:text-sm font-bold text-slate-500 uppercase tracking-widest mb-3">Ringkasan Pesanan</h2>
                            
                            <div class="space-y-3 max-h-[300px] overflow-y-auto no-scrollbar pb-2">
                                @foreach($cart as $item)
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 pr-3">
                                        <p class="text-xs md:text-sm font-bold text-slate-800 leading-snug">{{ $item['name'] }}</p>
                                        <p class="text-[10px] md:text-[11px] text-slate-500 mt-0.5">{{ $item['quantity'] }}x @ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                        @if(isset($item['notes']) && $item['notes'])
                                            <p class="text-[9px] md:text-[10px] text-brand-primary bg-brand-secondary px-2 py-0.5 rounded flex-wrap mt-0.5 italic inline-block line-clamp-1">"{{ $item['notes'] }}"</p>
                                        @endif
                                    </div>
                                    <div class="flex-shrink-0 text-right">
                                        <p class="text-xs md:text-sm font-extrabold text-slate-800">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <hr class="my-4 border-slate-100 border-dashed">

                            <div class="flex justify-between items-center mb-1">
                                <p class="text-xs md:text-sm text-slate-500 font-medium">Subtotal</p>
                                <p class="text-xs md:text-sm font-extrabold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-[10px] md:text-[11px] text-brand-primary font-medium">Total Tagihan (Termasuk Pajak)</p>
                            </div>

                            <div class="bg-slate-50 rounded-xl md:rounded-2xl p-3 md:p-4 flex justify-between items-center mb-5">
                                <span class="text-xs md:text-sm font-bold text-slate-600">Total Bayar:</span>
                                <span class="text-lg md:text-2xl font-black text-brand-primary tracking-tight">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" class="w-full bg-brand-primary hover:bg-brand-dark active:scale-[0.98] text-white py-3 md:py-4 px-4 rounded-xl md:rounded-2xl font-bold text-sm md:text-base shadow-lg shadow-brand-primary/20 transition-all flex items-center justify-center gap-2 group">
                                <svg class="w-4 h-4 md:w-5 md:h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Proses Pesanan Sekarang
                            </button>
                            <p class="mt-3 text-center text-[9px] md:text-[10px] text-slate-400">
                                Dengan memproses pesanan, Anda menyetujui syarat & ketentuan kami.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</x-layouts.app>
