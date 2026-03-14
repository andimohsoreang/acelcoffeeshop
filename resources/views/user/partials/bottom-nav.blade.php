{{-- 
    BOTTOM NAVIGATION BAR 
    (Berjalan secara fixed di bawah layer PWA)
--}}
<div class="md:hidden fixed bottom-0 w-full bg-white border-t border-slate-100 pb-safe z-30 isolate transition-transform duration-300">
    <div class="flex justify-around items-end h-16 px-2 pb-2">
        
        {{-- Link Home --}}
        <a href="{{ route('home') }}" aria-label="Beranda" class="flex flex-col items-center justify-center w-16 h-12 gap-1 rounded-2xl transition-colors {{ request()->routeIs('home') ? 'text-amber-600' : 'text-slate-400 hover:text-slate-600' }}">
            <div class="relative {{ request()->routeIs('home') ? 'bg-amber-50' : '' }} p-1.5 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('home') ? '1.5' : '2' }}" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="text-[10px] font-semibold {{ request()->routeIs('home') ? 'font-bold' : '' }}">Beranda</span>
        </a>

        {{-- Link Menu / Katalog --}}
        <a href="{{ route('menu.index') }}" aria-label="Menu" class="flex flex-col items-center justify-center w-16 h-12 gap-1 rounded-2xl transition-colors {{ request()->routeIs('menu.*') ? 'text-amber-600' : 'text-slate-400 hover:text-slate-600' }}">
            <div class="relative {{ request()->routeIs('menu.*') ? 'bg-amber-50' : '' }} p-1.5 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="{{ request()->routeIs('menu.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('menu.*') ? '1.5' : '2' }}" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
            </div>
            <span class="text-[10px] font-semibold {{ request()->routeIs('menu.*') ? 'font-bold' : '' }}">Menu</span>
        </a>

        {{-- Link Cart Tengah (Menonjol Ke Atas / Floating effect) --}}
        @php
            $cartCount = count(session()->get('cart', []));
        @endphp
        <div class="relative -top-3">
            <div class="absolute inset-0 bg-white rounded-full scale-110 shadow-[0_-5px_15px_-5px_rgba(0,0,0,0.08)] -z-10"></div>
            <a href="{{ route('cart.index') }}" aria-label="Keranjang Belanja" class="flex items-center justify-center w-14 h-14 bg-gradient-to-tr from-amber-600 to-amber-400 text-white rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                @if($cartCount > 0)
                    <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm ring-2 ring-red-100 ring-offset-1">{{ $cartCount }}</span>
                @endif
            </a>
        </div>

        {{-- Riwayat (Pesanan) --}}
        <a href="{{ route('order.index') }}" aria-label="Pesanan Saya" class="flex flex-col items-center justify-center w-16 h-12 gap-1 rounded-2xl transition-colors {{ request()->routeIs('order.*') ? 'text-amber-600' : 'text-slate-400 hover:text-slate-600' }}">
            <div class="relative {{ request()->routeIs('order.*') ? 'bg-amber-50' : '' }} p-1.5 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="{{ request()->routeIs('order.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('order.*') ? '1.5' : '2' }}" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <span class="text-[10px] font-semibold {{ request()->routeIs('order.*') ? 'font-bold' : '' }}">Pesanan</span>
        </a>

        {{-- Reviews --}}
        <a href="{{ route('reviews.index') }}" aria-label="Ulasan" class="flex flex-col items-center justify-center w-16 h-12 gap-1 rounded-2xl transition-colors {{ request()->routeIs('reviews.*') ? 'text-amber-600' : 'text-slate-400 hover:text-slate-600' }}">
            <div class="relative {{ request()->routeIs('reviews.*') ? 'bg-amber-50' : '' }} p-1.5 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="{{ request()->routeIs('reviews.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('reviews.*') ? '1.5' : '2' }}" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <span class="text-[10px] font-semibold {{ request()->routeIs('reviews.*') ? 'font-bold' : '' }}">Reviews</span>
        </a>

    </div>
</div>

<style>
    /* Support iPhone safe area (Notch) */
    @@supports (padding-bottom: env(safe-area-inset-bottom)) {
        .pb-safe { padding-bottom: calc(env(safe-area-inset-bottom) * 1.5); }
    }
</style>
