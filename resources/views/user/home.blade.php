<x-layouts.app :title="$shopName">

{{-- ╔═══════════════════════════════════════════╗
     ║   HERO / WELCOME HEADER SECTION           ║
     ╚═══════════════════════════════════════════╝ --}}
<div class="relative bg-brand-primary text-white overflow-hidden
            md:mx-6 md:mt-6 md:rounded-3xl lg:mx-10 lg:mt-8">

    {{-- Background Ornaments --}}
    <div class="absolute inset-0 opacity-[0.07]"
         style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 28px 28px;">
    </div>
    <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -left-12 bottom-0 w-48 h-48 bg-brand-dark/20 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute right-0 bottom-0 w-40 h-40 bg-white/5 rounded-full blur-xl pointer-events-none"></div>

    <div class="relative z-10 px-5 pt-10 pb-6 md:px-10 md:pt-12 md:pb-10 lg:px-14 lg:pt-14 lg:pb-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        {{-- Left: Greeting + Info --}}
        <div class="max-w-xl">
            <p class="text-brand-secondary/80 text-xs md:text-sm font-semibold uppercase tracking-widest mb-1 md:mb-2">Hai, Penikmat Kopi ☕</p>
            <h1 class="text-2xl md:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight mb-3">{{ $shopName }}</h1>
            <p class="text-brand-secondary/90 text-sm md:text-base leading-relaxed mb-5 opacity-90 max-w-sm">
                {{ $shopDescription ?: 'Temukan sensasi rasa kopi terbaik yang diseduh khusus untuk mencerahkan hari Anda.' }}
            </p>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('menu.index') }}"
                   aria-label="Ke Halaman Menu Pesan Sekarang"
                   class="inline-flex items-center gap-2 bg-white text-brand-primary px-5 py-2.5 rounded-2xl text-sm font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all">
                    Pesan Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('cart.index') }}"
                   aria-label="Ke Halaman Keranjang Belanja"
                   class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border border-white/30 text-white px-4 py-2.5 rounded-2xl text-sm font-semibold hover:bg-white/30 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    Keranjang
                </a>
            </div>
        </div>

        {{-- Right: Tagline Card (desktop only) --}}
        <div class="hidden md:block flex-shrink-0 w-72 lg:w-80 bg-white/15 backdrop-blur-md border border-white/25 rounded-2xl p-5 shadow-xl">
            <h2 class="text-xl font-bold leading-snug text-white mb-3">{{ $shopTagline }}</h2>
            <div class="flex items-center gap-2 text-brand-secondary/90 text-xs font-medium">
                <svg class="w-4 h-4 flex-shrink-0 text-brand-secondary" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                Buka setiap hari, siap melayani Anda
            </div>
        </div>
    </div>

    {{-- Mobile only: Tagline mini card --}}
    <div class="md:hidden relative z-10 mx-5 mb-5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4">
        <h2 class="text-base font-bold leading-snug">{{ $shopTagline }}</h2>
    </div>
</div>


{{-- ╔═══════════════════════════════════════════╗
     ║   KATEGORI MENU                           ║
     ╚═══════════════════════════════════════════╝ --}}
<section class="mt-8 md:mt-10 mb-4 md:mb-6 px-5 md:px-6 lg:px-10">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base md:text-lg font-extrabold text-brand-dark">Kategori Menu</h3>
        <a href="{{ route('menu.index') }}" aria-label="Lihat Semua Kategori" class="text-xs md:text-sm font-semibold text-brand-primary hover:text-brand-dark transition-colors">Lihat Semua →</a>
    </div>

    {{-- Categories: scroll on mobile, wrap on desktop --}}
    <div class="flex overflow-x-auto no-scrollbar md:overflow-visible md:flex-wrap gap-2.5 md:gap-3 pb-2 md:pb-0 snap-x md:snap-none">
        <a href="{{ route('menu.index') }}"
           aria-label="Kategori Semua"
           class="flex flex-col items-center gap-2 flex-shrink-0 md:flex-shrink snap-start active:scale-95 md:hover:scale-105 transition-transform">
            <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-brand-secondary border border-brand-primary/10 flex items-center justify-center text-brand-primary shadow-sm">
                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            </div>
            <span class="text-[10px] md:text-xs font-semibold text-brand-dark">Semua</span>
        </a>

        @foreach($categories as $category)
        <a href="{{ route('menu.index', ['category' => $category->slug]) }}"
           aria-label="Kategori {{ $category->name }}"
           class="flex flex-col items-center gap-2 flex-shrink-0 md:flex-shrink snap-start active:scale-95 md:hover:scale-105 transition-transform">
            <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-white border border-slate-100 flex items-center justify-center shadow-sm text-lg md:text-xl" aria-hidden="true">
                {{ $category->icon ?: '☕' }}
            </div>
            <span class="text-[10px] md:text-xs font-semibold text-brand-dark truncate max-w-[56px] md:max-w-[64px]">{{ $category->name }}</span>
        </a>
        @endforeach
    </div>
</section>


{{-- ╔═══════════════════════════════════════════╗
     ║   MENU BARU (NEWCOMERS)                   ║
     ╚═══════════════════════════════════════════╝ --}}
@php
    $newcomers = \App\Models\Product::available()->newcomer()->with('category')->latest()->take(8)->get();
@endphp

@if($newcomers->count() > 0)
<section class="mt-2 mb-8 bg-brand-secondary/30 py-6 md:py-8 border-y border-brand-primary/5">
    <div class="flex items-center justify-between px-5 md:px-6 lg:px-10 mb-5">
        <h3 class="text-base md:text-lg font-extrabold text-brand-dark flex items-center gap-2">
            <span class="text-xl">🔥</span> Menu Baru Hits
        </h3>
    </div>

    {{-- Mobile: horizontal scroll | Tablet/Desktop: responsive grid --}}
    <div class="flex overflow-x-auto no-scrollbar gap-4 px-5 md:px-6 lg:px-10 pb-2 snap-x
                md:overflow-visible md:grid md:grid-cols-3 lg:grid-cols-4 md:gap-5 md:pb-0 md:snap-none">
        @foreach($newcomers as $product)
        <a href="{{ route('menu.show', $product->slug) }}"
           aria-label="Lihat detail menu {{ $product->name }}"
           class="flex-shrink-0 w-[150px] md:w-full bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden snap-start group relative hover:-translate-y-1 transition-all duration-300">

            {{-- NEW Badge --}}
            <div class="absolute top-2.5 left-2.5 z-10">
                <span class="px-2 py-0.5 bg-brand-accent text-white text-[9px] font-bold uppercase rounded-md shadow">NEW</span>
            </div>

            {{-- Product Image --}}
            <div class="h-[130px] md:h-[160px] w-full bg-slate-100 relative overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="300" height="300"
                         @if($loop->iteration <= 4) fetchpriority="high" @else loading="lazy" @endif
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                        <svg class="w-9 h-9 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="p-3 md:p-4">
                <p class="text-[10px] text-slate-400 font-medium mb-0.5 truncate">{{ $product->category->name ?? 'Menu' }}</p>
                <h4 class="text-xs md:text-sm font-bold text-brand-dark leading-snug mb-2 line-clamp-2">{{ $product->name }}</h4>
                <div class="flex items-center justify-between">
                    <p class="text-sm md:text-base font-extrabold text-brand-primary">{{ $product->formatted_price }}</p>
                    <span class="w-6 h-6 rounded-full bg-brand-secondary text-brand-primary flex items-center justify-center group-hover:bg-brand-primary group-hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif


{{-- ╔═══════════════════════════════════════════╗
     ║   REKOMENDASI UNGGULAN                    ║
     ╚═══════════════════════════════════════════╝ --}}
<section class="px-5 md:px-6 lg:px-10 mt-2 mb-10">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base md:text-lg font-extrabold text-brand-dark flex items-center gap-2">
            <span class="text-xl">⭐</span> Rekomendasi Unggulan
        </h3>
    </div>

    @if($featuredProducts->count() > 0)
        {{-- Responsive grid: 1 col mobile → 2 col tablet → 3 col desktop --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
            @foreach($featuredProducts as $product)
            <a href="{{ route('menu.show', $product->slug) }}"
               aria-label="Lihat detail menu {{ $product->name }}"
               class="flex gap-4 p-3.5 md:p-4 bg-white rounded-2xl shadow-sm border border-slate-100 items-center hover:shadow-md hover:-translate-y-0.5 active:bg-slate-50 transition-all duration-200">

                {{-- Compact Image --}}
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-xl bg-slate-50 flex-shrink-0 overflow-hidden relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="150" height="150" @if($loop->iteration <= 6) fetchpriority="high" @else loading="lazy" @endif class="w-full h-full object-cover">
                    @else
                        <svg class="w-8 h-8 text-slate-300 absolute inset-0 m-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @endif
                </div>

                {{-- Contents --}}
                <div class="flex-1 min-w-0 py-0.5">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="text-sm md:text-base font-bold text-brand-dark truncate pr-2">{{ $product->name }}</h4>
                        @if($product->rating_count > 0)
                            <div class="flex items-center gap-0.5 text-[10px] font-bold text-brand-primary bg-brand-secondary px-1.5 py-0.5 rounded-lg flex-shrink-0" aria-label="Rating {{ number_format($product->rating_avg, 1) }} dari 5">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                {{ number_format($product->rating_avg, 1) }}
                            </div>
                        @endif
                    </div>

                    <p class="text-[11px] text-slate-400 line-clamp-2 mb-2.5 leading-relaxed">{{ $product->description ?: 'Nikmati racikan kopi istimewa.' }}</p>

                    <div class="flex items-center justify-between">
                        <p class="text-sm md:text-base font-extrabold text-brand-primary">{{ $product->formatted_price }}</p>
                        <div class="w-7 h-7 bg-brand-dark text-white rounded-full flex items-center justify-center shadow-md hover:bg-brand-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-14 bg-white rounded-2xl border border-dashed border-slate-200">
            <p class="text-slate-400 text-sm">Belum ada menu rekomendasi saat ini.</p>
        </div>
    @endif
</section>

</x-layouts.app>
