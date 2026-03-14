import './bootstrap';
import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import axios from 'axios';

import AdminNotifications from './admin-notifications';

// ============================================================
// Setup semua global SEBELUM admin-notifications diinisialisasi
// ============================================================

// Axios — CSRF setup for admin AJAX requests
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Laravel Echo + Reverb (Admin only — realtime order notifications)
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Inisialisasi AdminNotifications SETELAH window.Echo tersedia
window.adminNotifications = new AdminNotifications();

// ============================================================
// Alpine.js — interaktivitas UI admin (modal, dropdown, dll)
// ============================================================
window.Alpine = Alpine;
Alpine.start();