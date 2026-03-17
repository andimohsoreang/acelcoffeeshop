<x-layouts.app title="Keranjang Belanja">

@php
    // Pre-load product slugs for linking cart items to their show pages
    $productIds = array_keys($cart);
    $slugMap = count($productIds) > 0
        ? \App\Models\Product::whereIn('id', $productIds)->pluck('slug', 'id')
        : collect();
@endphp

{{-- ══════════════════════════════════════════════════════
     STICKY HEADER
     ══════════════════════════════════════════════════════ --}}
<div class="sticky top-0 z-[55] bg-white/95 backdrop-blur-lg border-b border-slate-100 shadow-sm">
    <div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto px-4 md:px-6 flex items-center gap-3 h-14">
        <a href="{{ url()->previous() }}" aria-label="Kembali"
           class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <span class="text-sm font-bold text-slate-800 flex-1">Keranjang Belanja</span>
        @if(count($cart) > 0)
            <span class="text-xs text-slate-400 font-medium">{{ array_sum(array_column($cart, 'quantity')) }} item</span>
        @endif
    </div>
</div>

<div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto">

{{-- ══════════════════════════════════════════════════════
     EMPTY STATE
     ══════════════════════════════════════════════════════ --}}
@if(count($cart) === 0)
<div class="flex flex-col items-center justify-center px-6 py-20 text-center">
    {{-- Illustration --}}
    <div class="relative mb-8">
        <div class="w-32 h-32 bg-brand-secondary rounded-3xl flex items-center justify-center shadow-sm">
            <svg class="w-16 h-16 text-brand-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <div class="absolute -top-2 -right-2 w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center">
            <span class="text-lg">☕</span>
        </div>
    </div>
    <h2 class="text-lg font-extrabold text-slate-800 mb-2">Keranjang Masih Kosong</h2>
    <p class="text-sm text-slate-400 mb-8 max-w-xs leading-relaxed">
        Tambahkan minuman favoritmu dari menu kami dan nikmati setiap tegukan yang menyegarkan.
    </p>
    <a href="{{ route('menu.index') }}"
       class="inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-dark text-white font-bold text-sm rounded-2xl px-6 py-3 shadow-lg shadow-brand-primary/20 active:scale-95 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
        </svg>
        Lihat Menu
    </a>
</div>

@else

{{-- ══════════════════════════════════════════════════════
     CART ITEMS LIST
     ══════════════════════════════════════════════════════ --}}
<div class="px-4 md:px-6 pt-6 md:pt-10 pb-6 md:flex md:gap-16 md:items-start">

    {{-- LEFT COLUMN: Item list --}}
    <div class="md:flex-1 space-y-5">

        {{-- Section Header --}}
        <div class="flex items-center justify-between px-1 mb-6">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-6 bg-brand-primary rounded-full"></div>
                <h2 class="text-base font-extrabold text-slate-800">Pesanan Kamu</h2>
            </div>
            <form action="{{ route('cart.clear') }}" method="POST" id="clear-cart-form">
                @csrf
                <button type="button" onclick="showClearModal()" aria-label="Hapus semua item keranjang"
                        class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-500 rounded-xl text-[10px] font-bold flex items-center gap-1.5 transition-all active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Semua
                </button>
            </form>
        </div>

        @foreach($cart as $id => $item)
        {{-- Cart Item Card --}}
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 p-4">
            <div class="flex gap-4">

                {{-- Product Image --}}
                <a href="{{ $slugMap->has($id) ? route('menu.show', $slugMap[$id]) : route('menu.index') }}" aria-label="Lihat Menu {{ $item['name'] }}"
                   class="w-20 h-20 md:w-24 md:h-24 rounded-2xl overflow-hidden bg-slate-100 flex-shrink-0 relative group-hover:scale-[1.02] transition-transform duration-300">
                    @if(!empty($item['image']))
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="100" height="100" @if($loop->iteration <= 3) fetchpriority="high" @else loading="lazy" @endif
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-100">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </a>

                {{-- Item Info --}}
                <div class="flex-1 flex flex-col justify-between min-w-0">
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="text-base font-bold text-brand-dark leading-snug group-hover:text-brand-primary transition-colors truncate">
                                    {{ $item['name'] }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-sm font-extrabold text-brand-primary">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-medium">/ pcs</span>
                                </div>
                            </div>

                            {{-- Remove Button --}}
                            <button type="button" aria-label="Hapus item {{ $item['name'] }}"
                                    onclick="confirmRemove('{{ $id }}')"
                                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all active:scale-90">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>

                        @if(!empty($item['notes']))
                            <div class="mt-2 flex items-start gap-1.5 p-2 bg-slate-50 rounded-xl">
                                <span class="text-xs">📝</span>
                                <p class="text-[10px] text-slate-500 leading-tight italic line-clamp-2">
                                    {{ $item['notes'] }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Actions Row --}}
                    <div class="flex items-end justify-between mt-3 pt-3 border-t border-slate-50">
                        {{-- Quantity Stepper --}}
                        <div class="flex items-center bg-slate-100 rounded-xl p-1 border border-slate-200/50">
                            <button type="button" aria-label="Kurangi jumlah {{ $item['name'] }}"
                                    onclick="changeQty({{ $id }}, -1)"
                                    class="w-7 h-7 flex items-center justify-center bg-white rounded-lg shadow-sm text-slate-600 hover:text-red-500 transition-colors active:scale-90">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span id="qty-display-{{ $id }}" class="w-10 text-center text-sm font-extrabold text-slate-800">
                                {{ $item['quantity'] }}
                            </span>
                            <input type="hidden" name="quantity" id="qty-{{ $id }}" value="{{ $item['quantity'] }}">
                            <button type="button" aria-label="Tambah jumlah {{ $item['name'] }}"
                                    onclick="changeQty({{ $id }}, 1)"
                                    class="w-7 h-7 flex items-center justify-center bg-white rounded-lg shadow-sm text-slate-600 hover:text-brand-primary transition-colors active:scale-90">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Item Subtotal --}}
                        <div class="text-right">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Subtotal</p>
                            <p class="text-base font-extrabold text-slate-800 tracking-tight" id="subtotal-{{ $id }}">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hidden Forms --}}
            <form action="{{ route('cart.update', $id) }}" method="POST" id="qty-form-{{ $id }}" class="hidden">
                @csrf
                @method('PATCH')
                <input type="hidden" name="quantity" id="qty-form-input-{{ $id }}" value="{{ $item['quantity'] }}">
            </form>
            <form action="{{ route('cart.remove', $id) }}" method="POST" id="remove-form-{{ $id }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
        @endforeach
    </div>{{-- end left column --}}

    {{-- RIGHT COLUMN (desktop): Order Summary --}}
    <div class="hidden md:block md:w-[340px] flex-shrink-0 sticky top-24">
        <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Ringkasan Pesanan
            </h3>

            <div class="space-y-4 max-h-[40vh] overflow-y-auto no-scrollbar mb-6 px-1">
                @foreach($cart as $id => $item)
                <div class="flex items-start justify-between gap-3 text-sm">
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-slate-700 truncate">{{ $item['name'] }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <span class="font-extrabold text-slate-800 flex-shrink-0">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-dashed border-slate-200 pt-6 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-slate-500">Subtotal</span>
                    <span class="text-base font-extrabold text-slate-800" id="desktop-subtotal">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </span>
                </div>
                {{-- Add potential shipping/discount lines here if ever needed --}}
                <div class="flex items-center justify-between pt-2">
                    <span class="text-base font-extrabold text-slate-800">Total Akhir</span>
                    <span class="text-xl font-black text-brand-primary tracking-tight" id="desktop-total">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="mt-8 space-y-3">
                <a href="{{ route('checkout.index') }}" aria-label="Lanjutkan Proses Checkout"
                   class="w-full flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-dark text-white font-extrabold text-sm rounded-2xl py-4 shadow-xl shadow-brand-primary/20 active:scale-[0.97] transition-all group">
                    <span>Lanjutkan Checkout</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                <a href="{{ route('menu.index') }}"
                   class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl border border-slate-100 text-xs font-bold text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Tambah Produk Lagi
                </a>
            </div>
        </div>
    </div>

</div>{{-- end flex wrapper --}}

{{-- ══════════════════════════════════════════════════════
     MOBILE BOTTOM SUMMARY BAR
     ══════════════════════════════════════════════════════ --}}
<div class="md:hidden fixed left-0 right-0 z-[70] bg-white border-t border-slate-100 shadow-[0_-8px_30px_rgba(0,0,0,0.06)] px-5 pt-4 pb-4"
     style="bottom:76px;">
    <div class="flex items-center justify-between gap-4">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Total Pesanan</span>
            <span class="text-lg font-black text-brand-primary leading-none tracking-tight" id="mobile-total">
                Rp {{ number_format($subtotal, 0, ',', '.') }}
            </span>
        </div>
        <a href="{{ route('checkout.index') }}" aria-label="Buka Halaman Checkout"
           class="flex-1 flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-dark text-white font-extrabold text-sm rounded-2xl py-3.5 shadow-xl shadow-brand-primary/20 active:scale-[0.97] transition-all">
            <span>Checkout Sekarang</span>
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</div>

@endif

{{-- ══════════════════════════════════════════════════════
     CLEAR ALL CONFIRMATION MODAL
     ══════════════════════════════════════════════════════ --}}
<div id="clear-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center">
    <div class="absolute inset-0 bg-black/40" onclick="closeClearModal()"></div>
    <div class="relative mx-6 w-full max-w-xs bg-white rounded-3xl shadow-2xl overflow-hidden z-10">
        <div class="flex flex-col items-center text-center px-6 pt-8 pb-6">
            <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-[15px] font-extrabold text-slate-800 mb-1">Hapus semua item?</h3>
            <p class="text-xs text-slate-400 leading-relaxed">Seluruh item akan dihapus dari keranjang belanjamu.</p>
        </div>
        <div class="border-t border-slate-100 flex items-center">
            <button onclick="closeClearModal()"
                    class="flex-1 py-3.5 text-sm font-bold text-slate-500 hover:bg-slate-50 active:bg-slate-100 transition-colors">
                Batalkan
            </button>
            <div class="w-px h-10 bg-slate-100 flex-shrink-0"></div>
            <button onclick="doClear()"
                    class="flex-1 py-3.5 text-sm font-bold text-red-500 hover:bg-red-50 active:bg-red-100 transition-colors">
                Ya, Hapus Semua
            </button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     DELETE CONFIRMATION MODAL
     ══════════════════════════════════════════════════════ --}}
<div id="delete-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40" onclick="closeDeleteModal()"></div>
    {{-- Card --}}
    <div class="relative mx-6 w-full max-w-xs bg-white rounded-3xl shadow-2xl overflow-hidden z-10">
        {{-- Content --}}
        <div class="flex flex-col items-center text-center px-6 pt-8 pb-6">
            <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-[15px] font-extrabold text-slate-800 mb-1">Hapus item ini?</h3>
            <p class="text-xs text-slate-400 leading-relaxed">Item akan dihapus dari keranjang belanjamu.</p>
        </div>
        {{-- Buttons row --}}
        <div class="border-t border-slate-100 flex items-center">
            <button onclick="closeDeleteModal()"
                    class="flex-1 py-3.5 text-sm font-bold text-slate-500 hover:bg-slate-50 active:bg-slate-100 transition-colors">
                Batalkan
            </button>
            <div class="w-px h-10 bg-slate-100 flex-shrink-0"></div>
            <button onclick="doDelete()"
                    class="flex-1 py-3.5 text-sm font-bold text-red-500 hover:bg-red-50 active:bg-red-100 transition-colors">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

</div>{{-- end max-w wrapper --}}

@push('scripts')
<script>
    const itemPrices = {
        @foreach($cart as $id => $item)
        {{ $id }}: {{ $item['price'] }},
        @endforeach
    };

    // Pending debounce timers per item
    const _timers = {};

    function formatRupiah(amount) {
        return 'Rp ' + Math.round(amount).toLocaleString('id-ID');
    }

    function confirmRemove(id) {
        showDeleteModal(id);
    }

    function changeQty(id, delta) {
        const hidden = document.getElementById('qty-' + id);
        const display = document.getElementById('qty-display-' + id);
        if (!hidden) return;

        let current = parseInt(hidden.value) || 1;
        let newVal = current + delta;

        if (newVal < 1) {
            // Show confirmation modal to delete item
            showDeleteModal(id);
            return;
        }
        if (newVal > 99) newVal = 99;

        hidden.value = newVal;
        if (display) display.textContent = newVal;

        // Also update the hidden form input
        const formInput = document.getElementById('qty-form-input-' + id);
        if (formInput) formInput.value = newVal;

        // Update this item's subtotal
        const price = itemPrices[id] || 0;
        const subtotalEl = document.getElementById('subtotal-' + id);
        if (subtotalEl) subtotalEl.textContent = formatRupiah(price * newVal);

        // Recalculate grand total
        recalcTotal();

        // Debounce server submit
        clearTimeout(_timers[id]);
        _timers[id] = setTimeout(() => {
            const form = document.getElementById('qty-form-' + id);
            if (form) form.submit();
        }, 800);
    }

    function recalcTotal() {
        let total = 0;
        for (const [id, price] of Object.entries(itemPrices)) {
            const hidden = document.getElementById('qty-' + id);
            const qty = hidden ? (parseInt(hidden.value) || 0) : 0;
            total += price * qty;
        }
        const mobileTotal = document.getElementById('mobile-total');
        if (mobileTotal) mobileTotal.textContent = formatRupiah(total);
        const desktopTotal = document.getElementById('desktop-total');
        if (desktopTotal) desktopTotal.textContent = formatRupiah(total);
    }

    // ── Delete Confirmation Modal ─────────────────────────────
    let _deleteTargetId = null;

    function showDeleteModal(id) {
        _deleteTargetId = id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        _deleteTargetId = null;
        document.getElementById('delete-modal').classList.add('hidden');
    }

    function doDelete() {
        if (_deleteTargetId !== null) {
            const form = document.getElementById('remove-form-' + _deleteTargetId);
            if (form) form.submit();
        }
        closeDeleteModal();
    }
    // ── Clear All Modal ───────────────────────────────────
    function showClearModal() {
        document.getElementById('clear-modal').classList.remove('hidden');
    }

    function closeClearModal() {
        document.getElementById('clear-modal').classList.add('hidden');
    }

    function doClear() {
        const form = document.getElementById('clear-cart-form');
        if (form) form.submit();
        closeClearModal();
    }
</script>
@endpush

</x-layouts.app>
