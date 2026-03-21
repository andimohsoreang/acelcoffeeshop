{{--
    TOP NAVIGATION BAR
    Visible only on tablet (md) and desktop (lg+)
    Hidden on mobile — bottom-nav is used there instead
--}}
<nav class="hidden md:flex sticky top-0 z-50 w-full bg-white/90 backdrop-blur-lg border-b border-slate-100 shadow-sm">
    <div class="w-full max-w-5xl lg:max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between h-16">

        {{-- Brand Logo + Name --}}
        <a href="{{ route('home') }}" aria-label="Beranda Coffee Shop" class="flex items-center gap-2.5 group">
            <div class="w-9 h-9 bg-brand-primary rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-lg font-extrabold tracking-tight text-brand-dark">
                {{ setting('shop_name', 'Kopi Nusantara') }}
            </span>
        </a>

        {{-- Center Navigation Links --}}
        <div class="flex items-center gap-1">
            <a href="{{ route('home') }}"
               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('home') ? 'text-brand-primary bg-brand-secondary' : 'text-brand-muted hover:text-brand-dark hover:bg-brand-secondary/50' }}">
                <svg class="w-4 h-4" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <a href="{{ route('menu.index') }}"
               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('menu.*') ? 'text-brand-primary bg-brand-secondary' : 'text-brand-muted hover:text-brand-dark hover:bg-brand-secondary/50' }}">
                <svg class="w-4 h-4" fill="{{ request()->routeIs('menu.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                Menu
            </a>
            <a href="{{ route('order.index') }}"
               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('order.*') ? 'text-brand-primary bg-brand-secondary' : 'text-brand-muted hover:text-brand-dark hover:bg-brand-secondary/50' }}">
                <svg class="w-4 h-4" fill="{{ request()->routeIs('order.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Pesanan
            </a>
        </div>

        {{-- Right: Cart + Profile --}}
        <div class="flex items-center gap-3">

            {{-- Cart Button with Badge --}}
            @php $navCartCount = count(session()->get('cart', [])); @endphp
            <a href="{{ route('cart.index') }}" aria-label="Keranjang Belanja ({{ $navCartCount }} item)" class="relative w-10 h-10 bg-brand-secondary/50 hover:bg-brand-secondary rounded-xl flex items-center justify-center transition-colors group">
                <svg class="w-5 h-5 text-brand-muted group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                @if($navCartCount > 0)
                    <span class="cart-count-badge absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white shadow">{{ $navCartCount }}</span>
                @else
                    <span class="cart-count-badge hidden absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white shadow">0</span>
                @endif
            </a>

            {{-- Reviews Button --}}
            <a href="{{ route('reviews.index') }}" class="flex items-center gap-2 pl-3 pr-4 py-2 bg-brand-accent text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md hover:opacity-90 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Reviews
            </a>
        </div>
    </div>
</nav>
