<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} — {{ config('app.name', 'Admin') }}</title>

    {{-- Google Fonts: DM Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    <style>
        * {
            font-family: 'DM Sans', sans-serif;
        }

        .font-mono {
            font-family: 'DM Mono', monospace;
        }

        /* Sidebar scrollbar */
        #sidebar::-webkit-scrollbar {
            width: 4px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: #2d3748;
            border-radius: 4px;
        }

        /* Supabase-style subtle grid background on content */
        .content-bg {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Active nav glow */
        .nav-item.active {
            background: linear-gradient(90deg, rgba(62, 207, 142, 0.15) 0%, rgba(62, 207, 142, 0.05) 100%);
            border-left: 2px solid #3ecf8e;
        }

        /* Supabase green accent */
        :root {
            --accent: #3ecf8e;
            --accent-dark: #2bb578;
            --sidebar-bg: #1a1f2e;
            --sidebar-border: #2a3042;
            --sidebar-text: #94a3b8;
            --sidebar-text-hover: #f1f5f9;
        }

        /* Prevent Alpine FOUC (Flicker) */
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>

<body class="h-full bg-slate-50" x-data="{ sidebarOpen: false }">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-20 lg:hidden"></div>

    <div class="flex h-full">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Topbar --}}
            @include('admin.partials.topbar')

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto content-bg">
                <div class="px-6 py-6">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>

    {{-- Toast notification system --}}
    @include('admin.partials.toast')

    @stack('scripts')

</body>

</html>