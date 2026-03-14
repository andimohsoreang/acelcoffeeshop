{{-- ============================================================
SIDEBAR
============================================================ --}}
<aside id="sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-cloak
    class="fixed inset-y-0 left-0 z-30 w-60 flex flex-col overflow-y-auto transition-transform duration-200 ease-in-out lg:relative lg:translate-x-0 lg:flex"
    style="background-color: var(--sidebar-bg);">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-5" style="border-bottom: 1px solid var(--sidebar-border);">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm"
            style="background: var(--accent);">
            ☕
        </div>
        <div>
            <p class="text-white font-semibold text-sm leading-none">{{ \App\Models\Setting::get('shop_name', 'Coffee
                Shop') }}</p>
            <p class="text-xs mt-0.5" style="color: var(--sidebar-text);">Admin Panel</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5">

        {{-- Utama --}}
        <p class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest" style="color: #475569;">Utama</p>

        <a href="{{ route('admin.dashboard') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.dashboard') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.orders.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.orders.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.orders.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="flex-1">Orders</span>
            @php $pendingCount = \App\Models\Order::today()->byStatus('pending')->count(); @endphp
            @if($pendingCount > 0)
            <span id="order-notification-badge"
                class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full"
                style="background: var(--accent);">{{ $pendingCount }}</span>
            @else
            <span id="order-notification-badge"
                class="hidden inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full"
                style="background: var(--accent);"></span>
            @endif
        </a>

        {{-- Katalog --}}
        <div class="my-2" style="border-top: 1px solid var(--sidebar-border);"></div>
        <p class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest" style="color: #475569;">Katalog</p>

        <a href="{{ route('admin.products.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.products.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.products.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Produk
        </a>

        <a href="{{ route('admin.showcases.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.showcases.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.showcases.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            <span class="flex-1">Etalase Unggulan</span>
            <span class="inline-flex items-center justify-center px-1.5 py-[1px] text-[9px] font-bold text-white rounded-md uppercase" style="background: rgba(255,166,0,0.85);">Top</span>
        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.categories.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.categories.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            Kategori
        </a>

        {{-- Lainnya --}}
        <div class="my-2" style="border-top: 1px solid var(--sidebar-border);"></div>
        <p class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest" style="color: #475569;">Lainnya</p>

        <a href="{{ route('admin.customers.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.customers.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.customers.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Pelanggan
        </a>

        <a href="{{ route('admin.reviews.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.reviews.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.reviews.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            Reviews
        </a>

        <a href="{{ route('admin.finance.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.finance.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.finance.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Keuangan
        </a>

        <a href="{{ route('admin.reports.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.reports.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.reports.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Laporan
        </a>

        <a href="{{ route('admin.qris.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.qris.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.qris.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            QRIS
        </a>

        <a href="{{ route('admin.bank-accounts.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.bank-accounts.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.bank-accounts.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
            </svg>
            Rekening Bank
        </a>

        <a href="{{ route('admin.settings.index') }}"
            class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.settings.*') ? 'active text-white' : '' }}"
            style="color: {{ request()->routeIs('admin.settings.*') ? '#fff' : 'var(--sidebar-text)' }};"
            onmouseover="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text-hover)'; this.style.background='rgba(255,255,255,0.05)'"
            onmouseout="if(!this.classList.contains('active')) this.style.color='var(--sidebar-text)'; this.style.background=''">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Pengaturan
        </a>

    </nav>

    {{-- User info + logout --}}
    <div class="px-3 py-4" style="border-top: 1px solid var(--sidebar-border);">
        <div class="flex items-center gap-3 px-3 py-2 rounded-lg" style="background: rgba(255,255,255,0.04);">
            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                style="background: var(--accent);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs truncate" style="color: var(--sidebar-text);">{{ auth()->user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" title="Logout" class="transition-colors" style="color: var(--sidebar-text);"
                    onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--sidebar-text)'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>