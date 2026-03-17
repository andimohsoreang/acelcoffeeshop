<x-layouts.app title="Menu — Katalog Produk">

{{-- ══════════════════════════════════════════════════════
     STICKY HEADER: Search + Category Filter
     ══════════════════════════════════════════════════════ --}}
<div class="sticky top-0 md:top-16 z-[55] bg-white/95 backdrop-blur-lg border-b border-slate-100 shadow-sm">
    <div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto px-4 md:px-6 lg:px-10 pt-3 pb-2 space-y-2.5">

        {{-- Search Bar --}}
        <form method="GET" action="{{ route('menu.index') }}">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="relative flex items-center">
                <span class="absolute left-3.5 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                       aria-label="Cari menu favorit kamu"
                       placeholder="Cari menu favorit kamu..."
                       class="w-full pl-10 pr-10 py-2.5 bg-brand-secondary/50 border border-brand-primary/10 rounded-2xl text-sm text-brand-dark placeholder-brand-muted focus:outline-none focus:ring-2 focus:ring-brand-primary/30 transition-all">
                @if(request('search'))
                <a href="{{ route('menu.index', array_filter(['category' => request('category')])) }}"
                   aria-label="Hapus kata kunci pencarian"
                   class="absolute right-3 text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
                @endif
            </div>
        </form>

        {{-- Category Chips --}}
        <div class="flex overflow-x-auto no-scrollbar gap-2 pb-1">
            <a href="{{ route('menu.index', array_filter(['search' => request('search')])) }}"
               aria-label="Urutkan Semua Kategori"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap
                      {{ $selectedCategory === 'semua' ? 'bg-brand-primary text-white shadow-md shadow-brand-primary/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                🍽️ Semua
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('menu.index', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}"
               aria-label="Kategori {{ $cat->name }}"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-bold transition-all whitespace-nowrap
                      {{ $selectedCategory === $cat->slug ? 'bg-brand-primary text-white shadow-md shadow-brand-primary/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                @if($cat->icon)<span aria-hidden="true">{{ $cat->icon }}</span>@endif {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════
     HEADING + COUNT
     ══════════════════════════════════════════════════════ --}}
<div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto px-4 md:px-6 lg:px-10 pt-4 pb-3 flex items-end justify-between">
    <div>
        <h2 class="text-base md:text-xl font-extrabold text-brand-dark leading-tight">
            @if(request('search'))
                Hasil "<span class="text-brand-primary">{{ request('search') }}</span>"
            @elseif($selectedCategory !== 'semua')
                @php $activeCat = $categories->firstWhere('slug', $selectedCategory); @endphp
                {{ $activeCat?->icon }} {{ $activeCat?->name ?? 'Kategori' }}
            @else
                Semua Menu
            @endif
        </h2>
        <p class="text-xs text-slate-400 mt-0.5">{{ $products->total() }} produk</p>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════
     PRODUCT GRID
     ══════════════════════════════════════════════════════ --}}
<div class="w-full max-w-5xl lg:max-w-7xl md:mx-auto px-3 md:px-6 lg:px-10 pb-28 md:pb-10">

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
            @foreach($products as $product)
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">

                {{-- Product Image — fixed height for uniform cards --}}
                <a href="{{ route('menu.show', $product->slug) }}" aria-label="Lihat detail menu {{ $product->name }}" class="block relative overflow-hidden bg-slate-100 flex-shrink-0" style="aspect-ratio:4/3;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="400" height="300" @if($loop->iteration <= 4 && $products->currentPage() == 1) fetchpriority="high" @else loading="lazy" @endif
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif

                    {{-- Badges --}}
                    <div class="absolute top-2 left-2 flex flex-col gap-1">
                        @if($product->is_newcomer)
                            <span class="px-1.5 py-0.5 text-[9px] font-bold uppercase bg-red-500 text-white rounded-md shadow">NEW</span>
                        @endif
                        @if($product->is_featured)
                            <span class="px-1.5 py-0.5 text-[9px] font-bold uppercase bg-brand-primary text-brand-secondary rounded-md shadow">⭐</span>
                        @endif
                    </div>

                    {{-- Rating Chip --}}
                    @if($product->rating_count > 0)
                    <div class="absolute top-2 right-2 flex items-center gap-0.5 bg-black/50 backdrop-blur-sm text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full" aria-label="Rating {{ number_format($product->rating_avg, 1) }} dari 5">
                        <svg class="w-2.5 h-2.5 text-brand-secondary" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ number_format($product->rating_avg, 1) }}
                    </div>
                    @endif
                </a>

                {{-- Product Info — flex-grow to equalize card heights --}}
                     <div class="p-2.5 flex flex-col flex-1">
                    <p class="text-[9px] text-slate-400 font-medium truncate mb-0.5">{{ $product->category->name ?? '—' }}</p>
                    <a href="{{ route('menu.show', $product->slug) }}">
                        <h3 class="text-[11px] md:text-xs font-bold text-brand-dark line-clamp-2 leading-snug mb-1.5 flex-1">{{ $product->name }}</h3>
                    </a>

                    {{-- Price + Quick Add Button (all sizes) --}}
                    <div class="flex items-center justify-between gap-1 mt-auto">
                        <p class="text-xs font-extrabold text-brand-primary leading-none">{{ $product->formatted_price }}</p>

                        @if($product->is_available && $product->stock > 0)
                        {{-- Mobile: opens bottom sheet --}}
                        <button type="button" aria-label="Tambah {{ $product->name }} ke keranjang"
                                onclick="openQuickAdd({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ $product->formatted_price }}', {{ $product->stock }}, '{{ $product->image ? asset('storage/'.$product->image) : '' }}', {{ $product->price }})"
                                class="md:hidden w-8 h-8 bg-brand-primary hover:bg-brand-dark text-white rounded-full flex items-center justify-center shadow-md hover:shadow-lg active:scale-90 transition-all flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </button>
                        @else
                        <span aria-label="Stok Menu Habis" class="md:hidden w-8 h-8 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </span>
                        @endif
                    </div>

                    {{-- Desktop/Tablet: full-width add-to-cart button --}}
                    @if($product->is_available && $product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="hidden md:block mt-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                                aria-label="Tambah {{ $product->name }} ke Keranjang"
                                class="w-full flex items-center justify-center gap-1.5 bg-brand-primary hover:bg-brand-dark text-white text-xs font-bold rounded-xl py-2 shadow-sm hover:shadow-md active:scale-[0.97] transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Tambah ke Keranjang
                        </button>
                    </form>
                    @else
                    <div class="hidden md:flex mt-2 w-full items-center justify-center gap-1.5 bg-slate-100 text-slate-400 text-xs font-bold rounded-xl py-2">
                        Stok Habis
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        @if($products->hasPages())
        <div class="flex items-center justify-center gap-2 mt-8 mb-2">
            @if($products->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 text-slate-300" aria-label="Tidak ada Halaman sebelumnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <a href="{{ $products->previousPageUrl() }}" aria-label="Halaman sebelumnya" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-brand-primary/10 text-brand-muted hover:bg-brand-secondary hover:border-brand-primary/30 hover:text-brand-primary transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
            @endif

            @foreach($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                @if($page == $products->currentPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-full bg-brand-primary text-white text-sm font-bold shadow-md" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" aria-label="Ke Halaman {{ $page }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-brand-primary/10 text-brand-muted text-sm font-semibold hover:bg-brand-secondary hover:border-brand-primary/30 hover:text-brand-primary transition-colors">{{ $page }}</a>
                @endif
            @endforeach

            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" aria-label="Halaman selanjutnya" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-brand-primary/10 text-brand-muted hover:bg-brand-secondary hover:border-brand-primary/30 hover:text-brand-primary transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 text-slate-300" aria-label="Tidak ada Halaman selanjutnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>
        <p class="text-center text-xs text-slate-400 mb-4">Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}</p>
        @endif

    @else
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mb-5 text-4xl">☕</div>
            <h3 class="text-base font-bold text-brand-dark mb-1">Produk tidak ditemukan</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-xs">
                @if(request('search'))
                    Tidak ada yang cocok dengan "<strong>{{ request('search') }}</strong>". Coba kata kunci lain.
                @else
                    Belum ada produk di kategori ini.
                @endif
            </p>
            <a href="{{ route('menu.index') }}" class="px-5 py-2.5 bg-brand-primary text-white text-sm font-bold rounded-2xl shadow-md hover:bg-brand-dark active:scale-95 transition-all">
                Lihat Semua Menu
            </a>
        </div>
    @endif
</div>


{{-- ══════════════════════════════════════════════════════
     QUICK ADD BOTTOM SHEET (Mobile-Friendly Modal)
     ══════════════════════════════════════════════════════ --}}
{{-- Overlay --}}
<div id="quick-add-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-50 hidden" onclick="closeQuickAdd()"></div>

{{-- Compact Bottom Sheet --}}
<div id="quick-add-sheet" class="fixed bottom-0 left-0 right-0 z-50 transform translate-y-full transition-transform duration-300 ease-out">
    <div class="bg-white rounded-t-2xl shadow-2xl px-4 pt-3 pb-5">

        {{-- Handle --}}
        <div class="w-8 h-1 bg-slate-200 rounded-full mx-auto mb-3"></div>

        {{-- Single-row compact layout --}}
        <form id="sheet-form" action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="sheet-product-id" value="">
            <input type="hidden" name="quantity" id="sheet-quantity" value="1">

            <div class="flex items-center gap-3">
                {{-- Thumbnail --}}
                <div id="sheet-img-wrapper" class="w-12 h-12 rounded-xl bg-slate-100 flex-shrink-0 overflow-hidden flex items-center justify-center">
                    <img id="sheet-img" src="" alt="Thumbnail Keranjang" width="48" height="48" loading="lazy" class="w-full h-full object-cover hidden">
                    <svg id="sheet-img-placeholder" class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>

                {{-- Name + Price --}}
                <div class="flex-1 min-w-0">
                    <h4 id="sheet-name" class="text-sm font-bold text-slate-800 truncate leading-tight"></h4>
                    <p id="sheet-price" class="text-xs font-bold text-brand-primary"></p>
                </div>

                {{-- Stepper --}}
                <div class="flex items-center gap-1.5 bg-slate-100 rounded-xl px-2 py-1.5 flex-shrink-0">
                    <button type="button" id="sheet-minus" aria-label="Kurangi jumlah"
                            class="w-7 h-7 rounded-lg bg-white flex items-center justify-center text-slate-500 shadow-sm active:scale-90 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                    </button>
                    <span id="sheet-qty" class="w-5 text-center text-sm font-extrabold text-slate-800">1</span>
                    <button type="button" id="sheet-plus" aria-label="Tambah jumlah"
                            class="w-7 h-7 rounded-lg bg-white flex items-center justify-center text-slate-500 shadow-sm active:scale-90 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="flex-shrink-0 flex items-center gap-1.5 bg-brand-primary hover:bg-brand-dark text-white font-bold text-xs rounded-xl px-4 py-2.5 shadow-md active:scale-95 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>


@push('scripts')
<script>
    let sheetMax = 99;
    let sheetQty = 1;
    let sheetBasePrice = 0; // raw numeric price in Rupiah

    // Format number as Indonesian Rupiah
    function formatRupiah(amount) {
        return 'Rp ' + Math.round(amount).toLocaleString('id-ID');
    }

    function openQuickAdd(productId, name, formattedPrice, stock, imgUrl, rawPrice) {
        sheetQty = 1;
        sheetMax = stock;
        sheetBasePrice = rawPrice || 0;

        document.getElementById('sheet-product-id').value = productId;
        document.getElementById('sheet-name').textContent = name;
        document.getElementById('sheet-price').textContent = formattedPrice;
        document.getElementById('sheet-quantity').value = 1;
        document.getElementById('sheet-qty').textContent = 1;

        const img = document.getElementById('sheet-img');
        const placeholder = document.getElementById('sheet-img-placeholder');
        if (imgUrl) {
            img.src = imgUrl;
            img.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            img.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        document.getElementById('quick-add-overlay').classList.remove('hidden');
        const sheet = document.getElementById('quick-add-sheet');
        sheet.classList.remove('translate-y-full');
        document.body.style.overflow = 'hidden';
    }

    function closeQuickAdd() {
        document.getElementById('quick-add-overlay').classList.add('hidden');
        document.getElementById('quick-add-sheet').classList.add('translate-y-full');
        document.body.style.overflow = '';
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('sheet-minus').addEventListener('click', () => {
            if (sheetQty > 1) {
                sheetQty--;
                document.getElementById('sheet-qty').textContent = sheetQty;
                document.getElementById('sheet-quantity').value = sheetQty;
                // Update price dynamically
                if (sheetBasePrice > 0) {
                    document.getElementById('sheet-price').textContent = formatRupiah(sheetBasePrice * sheetQty);
                }
            }
        });

        document.getElementById('sheet-plus').addEventListener('click', () => {
            if (sheetQty < sheetMax) {
                sheetQty++;
                document.getElementById('sheet-qty').textContent = sheetQty;
                document.getElementById('sheet-quantity').value = sheetQty;
                // Update price dynamically
                if (sheetBasePrice > 0) {
                    document.getElementById('sheet-price').textContent = formatRupiah(sheetBasePrice * sheetQty);
                }
            }
        });

        // Swipe to close
        const sheet = document.getElementById('quick-add-sheet');
        let startY = 0;
        sheet.addEventListener('touchstart', e => { startY = e.touches[0].clientY; });
        sheet.addEventListener('touchend', e => {
            if (e.changedTouches[0].clientY - startY > 80) closeQuickAdd();
        });
    });
</script>
@endpush

<style>
    .pb-safe-bottom { padding-bottom: max(1.25rem, env(safe-area-inset-bottom)); }
</style>

</x-layouts.app>
