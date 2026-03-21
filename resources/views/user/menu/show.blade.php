<x-layouts.app :title="$product->name">

{{-- ══════════════════════════════════════════════════════
     PAGE HEADER
     ══════════════════════════════════════════════════════ --}}
<div class="sticky top-0 md:top-16 z-30 bg-white/95 backdrop-blur-lg border-b border-slate-100 shadow-sm">
    <div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto px-4 md:px-6 flex items-center gap-3 h-14">
        <a href="{{ route('menu.index') }}" aria-label="Kembali ke menu"
           class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <span class="text-sm font-bold text-slate-800 truncate">{{ $product->name }}</span>

        {{-- Cart shortcut --}}
        <a href="{{ route('cart.index') }}" aria-label="Keranjang Belanja" class="ml-auto relative w-9 h-9 flex items-center justify-center rounded-full bg-brand-secondary/50 hover:bg-brand-secondary text-brand-muted hover:text-brand-primary transition-colors flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            @php $hCartCount = count(session()->get('cart', [])); @endphp
            @if($hCartCount > 0)
                <span class="cart-count-badge absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">{{ $hCartCount }}</span>
            @else
                <span class="cart-count-badge hidden absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">0</span>
            @endif
        </a>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════
     PRODUCT HERO IMAGE
     ══════════════════════════════════════════════════════ --}}
<div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto">

    {{-- Hero Image — aspect-ratio 16:9 on mobile, fixed tall on desktop, never clips --}}
    <div class="relative w-full md:mx-6 md:mt-6 md:rounded-2xl overflow-hidden bg-slate-100" style="aspect-ratio:16/9; max-height: 340px;">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" fetchpriority="high" width="600" height="340"
                 class="w-full h-full object-cover object-center">
            {{-- Gradient overlay for text legibility --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
        @else
            <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-slate-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-xs font-medium">Belum ada foto</p>
            </div>
        @endif

        {{-- Badges top-left --}}
        <div class="absolute top-3 left-3 flex gap-1.5 z-10">
            @if($product->is_newcomer)
                <span class="px-2 py-0.5 text-[10px] font-bold uppercase bg-red-500 text-white rounded-lg shadow-md">🔥 New</span>
            @endif
            @if($product->is_featured)
                <span class="px-2 py-0.5 text-[10px] font-bold uppercase bg-brand-primary text-brand-secondary rounded-lg shadow-md">⭐ Unggulan</span>
            @endif
        </div>

        {{-- Rating chip bottom-right --}}
        @if($product->rating_count > 0)
        <div class="absolute bottom-3 right-3 z-10 flex items-center gap-1 bg-black/60 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-full" aria-label="Rating {{ number_format($product->rating_avg, 1) }} dari 5">
            <svg class="w-3 h-3 text-brand-secondary" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            {{ number_format($product->rating_avg, 1) }}
            <span class="text-white/60 font-normal">({{ $product->rating_count }})</span>
        </div>
        @endif
    </div>


    {{-- PRODUCT DETAIL CONTENT --}}
    <div class="px-4 md:px-6 md:flex md:gap-10 md:mt-6 md:pb-6">

        {{-- LEFT: Info --}}
        <div class="pt-4 md:pt-0 md:flex-1">
            {{-- Category label --}}
            <p class="text-[10px] font-bold text-brand-primary uppercase tracking-widest mb-1">{{ $product->category->name ?? '—' }}</p>

            {{-- Product Name --}}
            <h1 class="text-xl md:text-2xl font-extrabold text-brand-dark leading-tight mb-2">{{ $product->name }}</h1>

            {{-- Star Rating --}}
            @if($product->rating_count > 0)
            <div class="flex items-center gap-2 mb-3">
                <div class="flex gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($product->rating_avg))
                            <svg class="w-3.5 h-3.5 text-brand-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-slate-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endif
                    @endfor
                </div>
                <span class="text-xs font-semibold text-slate-700">{{ number_format($product->rating_avg, 1) }}</span>
                <span class="text-[10px] text-slate-400">· {{ $product->rating_count }} ulasan</span>
            </div>
            @endif

            {{-- Description --}}
            @if($product->description)
            <p class="text-xs text-slate-500 leading-relaxed mb-3">{{ $product->description }}</p>
            @endif

            {{-- Divider --}}
            <div class="border-t border-slate-100 my-3"></div>

            {{-- Price (shown on mobile only) + Stock row --}}
            <div class="flex items-center justify-between gap-3 mb-3">
                <div>
                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Harga</p>
                    <p class="text-base font-extrabold text-brand-primary leading-tight">{{ $product->formatted_price }}</p>
                </div>
                @if($product->stock > 0)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 border border-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Stok {{ $product->stock }} pcs
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-100 text-red-600 text-[10px] font-bold rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        Stok Habis
                    </span>
                @endif
            </div>
        </div>

        {{-- RIGHT (desktop): Price + Cart on sidebar --}}
        <div class="hidden md:block md:w-72 lg:w-80 flex-shrink-0">
            @if($product->is_available && $product->stock > 0)
            <div class="sticky top-24 bg-brand-secondary border border-brand-primary/10 rounded-2xl p-5">
                <p class="text-xs text-slate-500 mb-1 font-medium">Harga</p>
                <p class="text-3xl font-extrabold text-brand-primary mb-4">{{ $product->formatted_price }}</p>

                <form action="{{ route('cart.add') }}" method="POST" class="ajax-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-sm text-slate-600 font-medium">Jumlah:</span>
                        <div class="flex items-center gap-1 bg-white rounded-xl border border-slate-200 shadow-sm ml-auto">
                            <button type="button" id="desktop-qty-minus" aria-label="Kurangi jumlah"
                                    class="w-8 h-8 flex items-center justify-center text-brand-muted hover:text-brand-primary hover:bg-brand-secondary rounded-l-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                            </button>
                            <input type="number" name="quantity" id="desktop-qty" value="1" min="1" max="{{ $product->stock }}"
                                   aria-label="Input jumlah pemesanan"
                                   class="w-10 h-8 text-center text-sm font-bold text-slate-800 bg-transparent border-none outline-none">
                            <button type="button" id="desktop-qty-plus" aria-label="Tambah jumlah"
                                    class="w-8 h-8 flex items-center justify-center text-brand-muted hover:text-brand-primary hover:bg-brand-secondary rounded-r-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-brand-primary text-white font-bold rounded-xl py-3 shadow-lg shadow-brand-primary/20 hover:bg-brand-dark active:scale-[0.97] transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
            @else
            <div class="sticky top-24 bg-slate-50 border border-slate-200 rounded-2xl p-5 text-center">
                <p class="text-3xl font-extrabold text-slate-400 mb-3">{{ $product->formatted_price }}</p>
                <div class="w-full py-3 bg-slate-200 text-slate-400 text-sm font-semibold rounded-xl">Tidak Tersedia</div>
            </div>
            @endif
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════
     ULASAN PELANGGAN
     ══════════════════════════════════════════════════════ --}}
@if($product->reviews->count() > 0)
<div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto px-4 md:px-6 mt-6 mb-4">
    <h2 class="text-base font-extrabold text-slate-800 mb-3 flex items-center gap-2">
        💬 Ulasan <span class="text-brand-primary">({{ $product->reviews->count() }})</span>
    </h2>
    <div class="space-y-3 md:grid md:grid-cols-2 md:gap-4 md:space-y-0">
        @foreach($product->reviews as $review)
        <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
            <div class="flex items-start justify-between gap-2 mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-primary to-brand-dark flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ mb_substr($review->customer_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800 leading-tight">{{ $review->customer_name }}</p>
                        <p class="text-[10px] text-slate-400">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-0.5 flex-shrink-0">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-brand-primary' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
            </div>
            @if($review->comment)
            <p class="text-sm text-slate-600 leading-relaxed pl-10">{{ $review->comment }}</p>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif


{{-- ══════════════════════════════════════════════════════
     MENU SERUPA
     ══════════════════════════════════════════════════════ --}}
@if($relatedProducts->count() > 0)
<div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto px-4 md:px-6 mt-3 pb-4 md:pb-10">
    <h2 class="text-xs font-extrabold text-slate-500 uppercase tracking-widest mb-3">Mungkin Kamu Suka</h2>
    <div class="grid grid-cols-3 gap-2">
        @foreach($relatedProducts as $rp)
        <div class="group bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-all flex flex-col">
            {{-- Image with correct aspect ratio, never clips --}}
            <a href="{{ route('menu.show', $rp->slug) }}" aria-label="Lihat Menu {{ $rp->name }}" class="block relative overflow-hidden bg-slate-50" style="aspect-ratio:4/3;">
                @if($rp->image)
                    <img src="{{ asset('storage/' . $rp->image) }}" alt="{{ $rp->name }}" loading="lazy" width="200" height="150"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </a>
            {{-- Info --}}
            <div class="px-1.5 pt-1.5 pb-1 flex-1 flex flex-col">
                <a href="{{ route('menu.show', $rp->slug) }}">
                    <p class="text-[10px] font-bold text-slate-800 line-clamp-2 leading-tight mb-0.5">{{ $rp->name }}</p>
                </a>
                <p class="text-[10px] font-extrabold text-brand-primary mb-1.5">{{ $rp->formatted_price }}</p>
                @if($rp->is_available && $rp->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $rp->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" aria-label="Tambah {{ $rp->name }} ke keranjang" class="w-full flex items-center justify-center gap-1 bg-brand-primary hover:bg-brand-dark text-white rounded-lg py-1 text-[9px] font-bold active:scale-95 transition-all">
                        <svg class="w-2.5 h-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Keranjang
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif


{{-- ══════════════════════════════════════════════════════
     MOBILE FIXED BOTTOM: Price + Add to Cart
     ══════════════════════════════════════════════════════ --}}
{{--
    Mobile sticky cart bar — positioned at bottom:64px so it sits
    directly above the 64px bottom navigation bar (no overlap)
--}}
@if($product->is_available && $product->stock > 0)
<div class="md:hidden fixed left-0 right-0 z-[70] bg-white/95 backdrop-blur-xl border-t border-slate-200 shadow-[0_-2px_20px_rgba(0,0,0,0.10)]" style="bottom:76px;">
    <form action="{{ route('cart.add') }}" method="POST" class="ajax-cart-form px-4 py-2.5">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" id="mobile-qty-val" value="1">

        {{-- Compact single-row layout --}}
        <div class="flex items-center gap-2">
            {{-- Price --}}
            <div class="flex-1 min-w-0">
                <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider leading-none">Harga</p>
                <p id="mobile-price-display" data-base-price="{{ $product->price }}"
                   class="text-sm font-extrabold text-brand-primary leading-tight">{{ $product->formatted_price }}</p>
            </div>

            {{-- Stepper --}}
            <div class="flex items-center bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                <button type="button" id="mobile-qty-minus" aria-label="Kurangi jumlah"
                        class="w-8 h-8 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors active:scale-90">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                </button>
                <span id="mobile-qty-display" class="w-7 text-center text-xs font-extrabold text-slate-800 select-none">1</span>
                <button type="button" id="mobile-qty-plus" aria-label="Tambah jumlah"
                        class="w-8 h-8 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors active:scale-90">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </button>
            </div>

            {{-- Add Button --}}
            <button type="submit"
                    class="flex items-center gap-1.5 bg-brand-primary hover:bg-brand-dark text-white font-bold text-xs rounded-xl px-4 h-8 shadow-md active:scale-[0.97] transition-all whitespace-nowrap flex-shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Tambah
            </button>
        </div>
    </form>
</div>
@else
<div class="md:hidden fixed left-0 right-0 z-[70] bg-white/95 backdrop-blur-xl border-t border-slate-200 px-4 py-2.5 flex items-center justify-between" style="bottom:76px;">
    <span class="text-sm font-extrabold text-slate-400">{{ $product->formatted_price }}</span>
    <span class="px-3 py-1.5 bg-slate-200 text-slate-400 text-[10px] font-bold rounded-xl">Tidak Tersedia</span>
</div>
@endif


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Mobile stepper on show page
    const maxStock = {{ $product->stock }};
    let mobileQty = 1;
    const display   = document.getElementById('mobile-qty-display');
    const hidden    = document.getElementById('mobile-qty-val');
    const priceEl   = document.getElementById('mobile-price-display');
    const basePrice = priceEl ? parseFloat(priceEl.dataset.basePrice) : 0;

    // Format number as Indonesian Rupiah
    function formatRupiah(amount) {
        return 'Rp ' + Math.round(amount).toLocaleString('id-ID');
    }

    function updateMobileQty(val) {
        mobileQty = Math.max(1, Math.min(val, maxStock));
        if (display)  display.textContent = mobileQty;
        if (hidden)   hidden.value = mobileQty;
        // Update price display = base price × qty
        if (priceEl)  priceEl.textContent = formatRupiah(basePrice * mobileQty);
    }

    document.getElementById('mobile-qty-minus')?.addEventListener('click', () => updateMobileQty(mobileQty - 1));
    document.getElementById('mobile-qty-plus')?.addEventListener('click',  () => updateMobileQty(mobileQty + 1));

    // AJAX Submit for All Cart Forms
    document.addEventListener('submit', async (e) => {
        const form = e.target.closest('.ajax-cart-form');
        if (!form) return;

        e.preventDefault();
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;
        const originalBtnHtml = submitBtn.innerHTML;

        // Loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<svg class="w-4 h-4 animate-spin mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            const result = await response.json();

            if (response.ok) {
                window.showToast(result.message || 'Berhasil ditambahkan!', 'success');
                
                // Update cart count badges globally
                document.querySelectorAll('.cart-count-badge').forEach(el => {
                    el.textContent = result.count;
                    el.classList.remove('hidden');
                });
            } else {
                window.showToast(result.message || 'Gagal menambahkan item.', 'error');
            }
        } catch (error) {
            console.error('Add to Cart Error:', error);
            window.showToast('Terjadi kesalahan koneksi.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnHtml;
        }
    });

    // Desktop stepper
    let desktopQty = 1;
    const dInput = document.getElementById('desktop-qty');
    document.getElementById('desktop-qty-minus')?.addEventListener('click', () => {
        if (desktopQty > 1) { desktopQty--; if (dInput) dInput.value = desktopQty; }
    });
    document.getElementById('desktop-qty-plus')?.addEventListener('click', () => {
        if (desktopQty < maxStock) { desktopQty++; if (dInput) dInput.value = desktopQty; }
    });
});
</script>
@endpush

</x-layouts.app>
