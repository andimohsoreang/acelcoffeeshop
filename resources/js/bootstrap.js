// ============================================================
// User-facing bootstrap (minimal)
// No Axios/Echo/Pusher — user pages use native HTML forms only
// ============================================================

// Set CSRF token for any native fetch() calls if ever needed
const csrfMeta = document.querySelector('meta[name="csrf-token"]');
if (csrfMeta) {
    window._csrf = csrfMeta.getAttribute('content');
}