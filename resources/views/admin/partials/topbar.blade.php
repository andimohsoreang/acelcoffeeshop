{{-- ============================================================
TOPBAR
============================================================ --}}
<header class="flex items-center gap-4 px-6 py-3.5 bg-white border-b border-slate-200 sticky top-0 z-10">

    {{-- Mobile hamburger --}}
    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-500 hover:text-slate-700">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    {{-- Page title --}}
    <div class="flex-1">
        <h1 class="text-sm font-semibold text-slate-800">{{ $title ?? 'Dashboard' }}</h1>
        @isset($subtitle)
        <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
        @endisset
    </div>

    {{-- Right side --}}
    <div class="flex items-center gap-3">

        {{-- Tanggal --}}
        <span class="hidden sm:block text-xs text-slate-400 font-mono">
            {{ now()->isoFormat('ddd, D MMM Y') }}
        </span>

        <div class="hidden sm:block w-px h-4 bg-slate-200"></div>

        {{-- Link ke toko --}}
        <a href="{{ route('home') }}" target="_blank"
            class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            Lihat Toko
        </a>

    </div>
</header>