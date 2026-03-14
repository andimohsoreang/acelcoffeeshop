import './bootstrap';
import './echo';         // Reverb WebSocket — realtime via Laravel Reverb
import './order-tracker'; // Realtime order tracker untuk halaman /orders/{code}
import Alpine from 'alpinejs';
import './pwa';

// ============================================================
// Alpine.js — interaktivitas UI (dropdown, modal, toggle, dll)
// ============================================================
window.Alpine = Alpine;
Alpine.start();