const CACHE_NAME = 'coffeeshop-v2';
const STATIC_CACHE = 'coffeeshop-static-v2';

// Daftar file yang di-cache saat pertama install
const STATIC_ASSETS = [
    '/',
    '/menu',
    '/manifest.json',
    '/offline.html',
    '/images/default-product.png',
    '/images/logo.png',
];

// ============================================================
// INSTALL — cache semua static assets
// ============================================================
self.addEventListener('install', (event) => {
    console.log('SW: Installing...');
    event.waitUntil(
        caches.open(STATIC_CACHE).then((cache) => {
            // Cache satu per satu — satu file gagal tidak merusak yang lain
            return Promise.allSettled(
                STATIC_ASSETS.map(url =>
                    cache.add(url).catch(err => {
                        console.warn(`SW: Gagal cache ${url}:`, err.message);
                    })
                )
            );
        })
    );
    self.skipWaiting();
});

// ============================================================
// ACTIVATE — hapus cache lama
// ============================================================
self.addEventListener('activate', (event) => {
    console.log('SW: Activating...');
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME && name !== STATIC_CACHE)
                    .map((name) => {
                        console.log('SW: Deleting old cache:', name);
                        return caches.delete(name);
                    })
            );
        })
    );
    self.clients.claim();
});

// ============================================================
// FETCH — strategi caching
// ============================================================
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip semua non-GET
    if (request.method !== 'GET') return;

    // Skip route admin — selalu ambil dari network
    if (url.pathname.startsWith('/admin')) return;

    // Skip checkout & order — data harus selalu fresh
    if (url.pathname.startsWith('/checkout') || url.pathname.startsWith('/order/')) return;

    // Static assets (gambar, css, js) → Cache First, fallback Network
    if (
        url.pathname.startsWith('/images/') ||
        url.pathname.startsWith('/build/') ||
        url.pathname.startsWith('/css/') ||
        url.pathname.startsWith('/js/')
    ) {
        event.respondWith(
            caches.match(request).then((cached) => {
                if (cached) return cached;
                return fetch(request).then((response) => {
                    const clone = response.clone();
                    caches.open(STATIC_CACHE).then((cache) => {
                        cache.put(request, clone);
                    });
                    return response;
                }).catch(() => {
                    // Ignore asset fetch failures
                });
            })
        );
        return;
    }

    // HTML Pages & API Calls → Network First, fallback to Offline Page
    event.respondWith(
        fetch(request)
            .then((response) => {
                // Simpan ke cache setelah berhasil fetch
                const clone = response.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(request, clone);
                });
                return response;
            })
            .catch(() => {
                // Jika fetch gagal (Offline), dan request adalah HTML (Halaman wweb)
                if (request.headers.get('accept').includes('text/html')) {
                    // Kembalikan custom offline page
                    return caches.match('/offline.html');
                }
                // Jika resource lain (API/Image), coba ambil dari cache terakhir
                return caches.match(request);
            })
    );
});