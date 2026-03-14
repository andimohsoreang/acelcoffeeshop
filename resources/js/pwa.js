// ============================================================
// FILE: resources/js/pwa.js
// Register Service Worker + PWA Install Prompt
// Diimport di app.js (user side saja)
// ============================================================

// ============================================================
// Register Service Worker
// ============================================================
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('/sw.js')
            .then((reg) => {
                console.log('✅ SW registered:', reg.scope);
            })
            .catch((err) => {
                console.error('❌ SW error:', err);
            });
    });
}

// ============================================================
// PWA Install Prompt
// Tombol install: <button id="pwa-install-btn" class="hidden">Install App</button>
// ============================================================
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    const installBtn = document.getElementById('pwa-install-btn');
    if (installBtn) {
        installBtn.classList.remove('hidden');

        installBtn.addEventListener('click', () => {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choice) => {
                if (choice.outcome === 'accepted') {
                    console.log('✅ PWA installed');
                } else {
                    console.log('❌ PWA dismissed');
                }
                deferredPrompt = null;
                installBtn.classList.add('hidden');
            });
        });
    }
});

window.addEventListener('appinstalled', () => {
    console.log('✅ PWA berhasil diinstall');
    deferredPrompt = null;
});