import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

// TAMPILKAN LOG PUSHER KE CONSOLE
Pusher.logToConsole = true;

// Mencekik error agar tampil di HP!
window.onerror = function(message, source, lineno, colno, error) {
    alert("Error JS: " + message + " at " + lineno);
};

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    // Ini penting! Jika HP memanggil 192.168.1.107, window.location.hostname akan otomatis mengatur IP Socket-nya ke angka tersebut, mencegah socket nembak ke 'localhost' (HP sendiri).
    wsHost: import.meta.env.VITE_REVERB_HOST === 'localhost' ? window.location.hostname : (import.meta.env.VITE_REVERB_HOST || window.location.hostname),
    wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws'],
});

window.Echo.connector.pusher.connection.bind('state_change', function(states) {
    console.log("[Reverb State]", states.current);
    if(states.current === 'unavailable' || states.current === 'failed' || states.current === 'disconnected') {
        alert("Socket Reverb Gagal/Terputus! Status: " + states.current);
    }
    if(states.current === 'connected') {
        console.log("REVERB TERKONEKSI SUKSES!");
    }
});
