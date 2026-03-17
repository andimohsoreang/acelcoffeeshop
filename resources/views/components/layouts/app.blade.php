<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-brand-secondary antialiased selection:bg-brand-primary/30">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    
    {{-- SEO & Open Graph Tags --}}
    <meta name="description" content="{{ $shopDescription ?? \App\Models\Setting::get('shop_description', 'Pesan kopi favoritmu dengan mudah dan cepat.') }}">
    <meta property="og:title" content="{{ $title ?? config('app.name', 'Coffee Shop') }}">
    <meta property="og:description" content="{{ $shopDescription ?? \App\Models\Setting::get('shop_description', 'Pesan kopi favoritmu dengan mudah dan cepat.') }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/icons/icon-512x512.png') }}">
    
    <meta name="theme-color" content="#ffffff">
    
    {{-- PWA Manifest & iOS Support --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Coffee Shop">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}">
    
    <title>{{ $title ?? config('app.name', 'Coffee Shop') }}</title>

    {{-- Fonts: Plus Jakarta Sans — Non-blocking preload --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Preload font CSS, then swap to stylesheet on load (non-render-blocking) --}}
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"></noscript>

    <script>
        // Tangkap SEMUA error sedini mungkin di level HTML murni
        window.onerror = function(msg, url, lineNo, columnNo, error) {
            console.error("JS Error: " + msg + " at " + lineNo);
            return false;
        };
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Prevent FOIT — fallback while Google Fonts loads async */
        body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }
        
        /* PWA Hide Scrollbar for cleaner look */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Smooth scrolling */
        html { scroll-behavior: smooth; }
        
        /* Prevent AlpineJS Flickr */
        [x-cloak] { display: none !important; }

        /* Custom Toast Animation - Slide from top */
        @keyframes slideDownFade {
            0% { transform: translateY(-100%); opacity: 0; }
            10% { transform: translateY(0); opacity: 1; }
            90% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(-100%); opacity: 0; }
        }
        .toast-animate { animation: slideDownFade 3s ease-in-out forwards; }

        /* Desktop sidebar subtle pattern */
        .desktop-bg { background: linear-gradient(135deg, #F8F1E7 0%, #ecd9c6 40%, #ffffff 100%); }
    </style>
    @stack('styles')
</head>
<body class="h-full text-brand-dark bg-brand-secondary">

    {{-- TOP NAVBAR: visible only on tablet and desktop --}}
    @if(!isset($hideNav) || !$hideNav)
        @include('user.partials.top-nav')
    @endif

    {{--
        Responsive App Wrapper:
        - Mobile: full width, no padding (feels like native app)
        - Tablet/Desktop: centered container with max-width, elegant drop shadow
    --}}
    <div class="w-full md:max-w-5xl lg:max-w-7xl mx-auto min-h-screen bg-brand-cream md:rounded-3xl md:my-6 md:shadow-xl flex flex-col overflow-x-hidden">

        {{-- Main View Content --}}
        <main class="flex-1 no-scrollbar pb-20 md:pb-10 relative">
            {{ $slot }}
        </main>

        {{-- Partial: Bottom Mobile Navigation (hidden on md+) --}}
        @if(!isset($hideNav) || !$hideNav)
            @include('user.partials.bottom-nav')
        @endif

    </div>

    {{-- PWA Install Banner --}}
    <div id="pwa-banner" style="display:none;position:fixed;bottom:80px;left:12px;right:12px;z-index:9999;background:#fff;border-radius:20px;box-shadow:0 8px 40px rgba(0,0,0,0.2);border:1px solid #fde68a;padding:16px;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            <img src="{{ asset('images/icons/icon-192x192.png') }}" alt="Coffee Shop" style="width:44px;height:44px;border-radius:10px;flex-shrink:0;">
            <div style="flex:1;min-width:0;">
                <p style="font-weight:800;font-size:14px;color:#1e293b;margin:0 0 2px;">Install Aplikasi Coffee Shop</p>
                <p style="font-size:11px;color:#64748b;margin:0;">Pasang di layar utama HP Anda!</p>
            </div>
            <button id="pwa-close" onclick="document.getElementById('pwa-banner').style.display='none';localStorage.setItem('pwa_dismissed','1');" style="width:28px;height:28px;border-radius:50%;background:#f1f5f9;border:none;cursor:pointer;flex-shrink:0;font-size:16px;line-height:1;" aria-label="Tutup">×</button>
        </div>
        <button id="pwa-install" style="width:100%;background:#f59e0b;color:#fff;border:none;border-radius:12px;padding:12px;font-size:14px;font-weight:700;cursor:pointer;">
            ☕ Install Sekarang
        </button>
        {{-- Modal instruksi manual --}}
        <div id="pwa-manual" style="display:none;margin-top:10px;background:#fef9ee;border-radius:12px;padding:12px;border:1px solid #fde68a;">
            <p style="font-size:12px;font-weight:700;color:#92400e;margin:0 0 6px;">Cara Install Manual:</p>
            <p style="font-size:11px;color:#78350f;margin:0;line-height:1.6;">
                1. Tekan tombol <strong>⋮</strong> (titik tiga) di sudut kanan atas Chrome<br>
                2. Pilih <strong>"Tambahkan ke layar utama"</strong> atau <strong>"Install app"</strong><br>
                3. Tekan <strong>Tambahkan</strong>
            </p>
        </div>
    </div>

    {{-- Flash Toast --}}
    @if(session('success') || session('error'))
        <div class="fixed top-20 left-4 right-4 md:left-auto md:right-8 md:w-80 z-[100] pointer-events-none toast-animate">
            <div class="bg-white/90 backdrop-blur-md border border-slate-100 px-4 py-3.5 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] flex items-center gap-3">
                @if(session('success'))
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-extrabold text-slate-800 leading-tight">
                            {{ session('success') }}
                        </p>
                    </div>
                @else
                    <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-extrabold text-slate-800 leading-tight">
                            {{ session('error') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @stack('scripts')

    <script>
        // SERVICE WORKER
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(function(r) { console.log('[SW] OK:', r.scope); })
                .catch(function(e) { console.log('[SW] Failed:', e); });
        }

        // PWA INSTALL BANNER
        (function() {
            var deferredPrompt = null;
            var banner = document.getElementById('pwa-banner');
            var btnInstall = document.getElementById('pwa-install');
            var manualBox = document.getElementById('pwa-manual');

            // Cek semua kondisi yang menandakan app sudah terinstall / tidak perlu banner
            var isStandalone = window.matchMedia('(display-mode: standalone)').matches
                            || window.matchMedia('(display-mode: fullscreen)').matches
                            || window.navigator.standalone  // iOS Safari
                            || document.referrer.startsWith('android-app://'); // Android TWA
            
            // Simpan status standalone ke localStorage untuk sesi berikutnya
            if (isStandalone) {
                localStorage.setItem('pwa_installed', '1');
            }

            // Jangan tampilkan banner jika:
            // 1. User sudah pernah dismiss
            // 2. Sudah running sebagai PWA standalone
            // 3. Sudah pernah install (flag tersimpan)
            if (localStorage.getItem('pwa_dismissed')) return;
            if (localStorage.getItem('pwa_installed')) return;
            if (isStandalone) return;

            // Tangkap event native jika tersedia (URL di-flag sebagai secure di Chrome)
            window.addEventListener('beforeinstallprompt', function(e) {
                e.preventDefault();
                deferredPrompt = e;
                console.log('[PWA] beforeinstallprompt captured!');
            });

            // Tampilkan banner setelah 3 detik
            setTimeout(function() {
                if (banner) banner.style.display = 'block';
            }, 3000);

            // Handler tombol Install
            if (btnInstall) {
                btnInstall.addEventListener('click', function() {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then(function(result) {
                            console.log('[PWA] choice:', result.outcome);
                            deferredPrompt = null;
                            if (result.outcome === 'accepted') {
                                localStorage.setItem('pwa_installed', '1');
                                if (banner) banner.style.display = 'none';
                            }
                        });
                    } else {
                        // Fallback: tampilkan instruksi manual
                        if (manualBox) {
                            manualBox.style.display = 'block';
                            btnInstall.style.display = 'none';
                        }
                    }
                });
            }

            // Jika berhasil terinstall via event appinstalled
            window.addEventListener('appinstalled', function() {
                localStorage.setItem('pwa_installed', '1');
                if (banner) banner.style.display = 'none';
                deferredPrompt = null;
                console.log('[PWA] App installed!');
            });
        })();
    </script>
</body>
</html>
