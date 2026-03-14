// ============================================================
// FILE: resources/js/order-tracker.js
// Realtime tracking status order untuk halaman user via Laravel Reverb
// Diinisialisasi dari show.blade.php via @push('scripts')
// ============================================================

window.initOrderTracker = function(orderCode) {
    if (!window.Echo) {
        console.warn('[Reverb] Echo belum siap, order tracker tidak aktif.');
        return;
    }

    console.log(`[Reverb] Listening on channel: order.${orderCode}`);

    // Tampilkan indikator "Live" di header (mobile & desktop)
    ['realtime-indicator-mobile', 'realtime-indicator-desktop'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.replace('hidden', 'inline-flex');
    });

    window.Echo.channel(`order.${orderCode}`)
        .listen('.order.status.updated', (data) => {
            console.log('[Reverb] order.status.updated received:', data);
            updateStatusBadge(data);
            updatePaymentStatus(data.payment_status);
            updateTimeline(data.status, data);
            showLiveToast(data.status_label, data.updated_at);
            requestBrowserNotification(data.status_label);
        });
};

// ============================================================
// Update Badge "Status Pesanan" di info card
// ============================================================
function updateStatusBadge(data) {
    const el = document.getElementById('order-status-text');
    if (!el) return;
    el.textContent = data.status_label;

    // Update warna wrapper
    const wrapper = document.getElementById('order-status-badge');
    if (!wrapper) return;

    const colorMap = {
        pending:     'text-amber-700',
        confirmed:   'text-blue-700',
        in_progress: 'text-orange-700',
        ready:       'text-green-700',
        completed:   'text-emerald-700',
        cancelled:   'text-red-700',
    };
    // Hapus semua kelas warna lama
    wrapper.className = wrapper.className.replace(/text-\w+-\d+/g, '').trim();
    wrapper.classList.add(colorMap[data.status] ?? 'text-slate-700', 'text-sm', 'md:text-base', 'font-black', 'capitalize');
}

// ============================================================
// Update Badge "Status Bayar" secara realtime
// ============================================================
function updatePaymentStatus(paymentStatus) {
    const wrapper = document.getElementById('payment-status-wrapper');
    if (!wrapper || !paymentStatus) return;

    const configs = {
        verified: {
            icon: `<span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-100 text-emerald-600">
                       <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                   </span>`,
            label: '<span class="text-xs md:text-sm font-black text-emerald-600 uppercase tracking-widest">Lunas</span>',
        },
        uploaded: {
            icon: `<span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-blue-100 text-blue-600">
                       <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                   </span>`,
            label: '<span class="text-xs md:text-sm font-black text-blue-600 uppercase tracking-widest">Menunggu</span>',
        },
        rejected: {
            icon: `<span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-red-100 text-red-600">
                       <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                   </span>`,
            label: '<span class="text-xs md:text-sm font-black text-red-600 uppercase tracking-widest">Ditolak</span>',
        },
    };

    const cfg = configs[paymentStatus];
    if (!cfg) return;

    wrapper.innerHTML = `
        <div class="flex items-center gap-1.5">
            ${cfg.icon}
            ${cfg.label}
        </div>
    `;

    // Tampilkan tombol struk jika lunas
    const receiptBtn = document.getElementById('receipt-button-container');
    const receiptStatusText = document.getElementById('receipt-payment-status');
    
    if (paymentStatus === 'verified') {
        if (receiptBtn) receiptBtn.classList.remove('hidden');
        if (receiptStatusText) receiptStatusText.textContent = 'LUNAS';
    } else if (paymentStatus === 'rejected') {
        if (receiptStatusText) receiptStatusText.textContent = 'DITOLAK';
    }

    // Flash animasi pada wrapper
    wrapper.style.transition = 'background 0.4s';
    wrapper.style.background = '#fef9c3';
    setTimeout(() => { wrapper.style.background = 'transparent'; }, 1500);
}

// ============================================================
// Update Timeline (lingkaran + teks status) secara realtime
// ============================================================
function updateTimeline(status, data) {
    const steps    = ['pending', 'confirmed', 'in_progress', 'ready', 'completed'];
    const currentIndex = steps.indexOf(status);

    steps.forEach((step, index) => {
        const circle   = document.getElementById(`step-circle-${step}`);
        const title    = document.getElementById(`step-title-${step}`);
        const subtitle = document.getElementById(`step-subtitle-${step}`);
        const row      = document.getElementById(`step-row-${step}`);

        if (!circle) return;

        const isDone   = index <= currentIndex;
        const isActive = index === currentIndex;

        // ── Lingkaran ──
        circle.classList.remove(
            'bg-amber-500', 'bg-green-500', 'bg-emerald-500', 'bg-slate-200',
            'shadow-sm', 'shadow-green-500/30', 'shadow-md', 'shadow-emerald-500/20'
        );

        if (step === 'ready' && isDone) {
            circle.classList.add('bg-green-500', 'shadow-sm', 'shadow-green-500/30');
        } else if (step === 'completed' && isDone) {
            circle.classList.add('bg-emerald-500', 'shadow-md', 'shadow-emerald-500/20');
        } else if (isDone) {
            circle.classList.add('bg-amber-500', 'shadow-sm');
        } else {
            circle.classList.add('bg-slate-200');
        }

        // ── Icon dalam lingkaran ──
        if (isDone) {
            const iconMap = {
                pending:     `<svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`,
                confirmed:   `<svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                in_progress: `<svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>`,
                ready:       `<svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>`,
                completed:   `<svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>`,
            };
            circle.innerHTML = iconMap[step] ?? '';
        } else {
            circle.innerHTML = `<div class="w-2 h-2 rounded-full bg-white opacity-50"></div>`;
        }

        // ── Warna teks judul ──
        if (title) {
            title.classList.remove(
                'text-slate-800', 'text-slate-400',
                'text-green-600', 'text-emerald-600'
            );
            if (step === 'ready' && isDone) {
                title.classList.add('text-green-600');
            } else if (step === 'completed' && isDone) {
                title.classList.add('text-emerald-600');
            } else if (isDone) {
                title.classList.add('text-slate-800');
            } else {
                title.classList.add('text-slate-400');
            }
        }

        // ── Subtitle / jam update ──
        if (subtitle) {
            if (step === 'confirmed' && isDone && data.confirmed_at) {
                subtitle.innerHTML = `<p class="text-[10px] lg:text-[11px] text-slate-400 font-medium mt-0.5">${data.confirmed_at} WIB</p>`;
            } else if (step === 'completed' && isDone && data.completed_at) {
                subtitle.innerHTML = `<p class="text-[10px] lg:text-[11px] text-slate-500 font-medium mt-0.5">${data.completed_at} WIB — Terima kasih sudah memesan! 😊</p>`;
            } else if (step === 'in_progress' && isActive) {
                subtitle.innerHTML = `<p class="text-[10px] lg:text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-bold mt-1 max-w-max">☕ Barista meracik pesananmu...</p>`;
            } else if (step === 'ready' && isActive) {
                subtitle.innerHTML = `<p class="text-[10px] lg:text-[11px] text-green-700 bg-green-50 px-2 py-0.5 rounded font-bold mt-1 max-w-max">🎉 Pesanan Anda siap di kasir!</p>`;
            } else if (step === 'confirmed' && isActive) {
                subtitle.innerHTML = `<p class="text-[10px] lg:text-[11px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded font-bold mt-1 max-w-max">Menunggu diproses dapur</p>`;
            } else {
                subtitle.innerHTML = '';
            }
        }

        // ── Pulse animation pada row aktif ──
        if (row) {
            row.classList.toggle('animate-pulse', isActive);
        }
    });
}

// ============================================================
// Toast Live Update (pojok kiri atas, auto-dismiss 4 detik)
// ============================================================
function showLiveToast(statusLabel, updatedAt) {
    // Hapus toast lama jika masih ada
    const old = document.getElementById('live-toast');
    if (old) old.remove();

    const toast = document.createElement('div');
    toast.id = 'live-toast';
    toast.style.cssText = `
        position: fixed; top: 72px; left: 50%; transform: translateX(-50%);
        z-index: 9999; display: flex; align-items: center; gap: 10px;
        background: white; border: 1px solid #e2e8f0;
        border-radius: 14px; padding: 12px 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        animation: liveToastIn 0.35s cubic-bezier(0.34,1.56,0.64,1) forwards;
        min-width: 240px; max-width: 90vw;
    `;
    toast.innerHTML = `
        <span style="width:32px;height:32px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:16px;">☕</span>
        <div style="flex:1;min-width:0;">
            <p style="font-size:12px;font-weight:800;color:#1e293b;margin:0;line-height:1.2;">Status Diperbarui!</p>
            <p style="font-size:11px;color:#64748b;margin:2px 0 0;">→ <strong>${statusLabel}</strong> · ${updatedAt} WIB</p>
        </div>
        <span style="width:8px;height:8px;background:#22c55e;border-radius:50%;flex-shrink:0;animation:pulse 1.5s infinite;"></span>
    `;

    // Inject keyframes jika belum ada
    if (!document.getElementById('live-toast-style')) {
        const style = document.createElement('style');
        style.id = 'live-toast-style';
        style.innerHTML = `
            @keyframes liveToastIn {
                0% { opacity: 0; transform: translateX(-50%) translateY(-12px) scale(0.95); }
                100% { opacity: 1; transform: translateX(-50%) translateY(0) scale(1); }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4500);
}

// ============================================================
// Browser Push Notification
// ============================================================
function requestBrowserNotification(statusLabel) {
    if (!('Notification' in window)) return;

    const show = () => {
        // Android Chrome melarang new Notification() langsung
        // Gunakan SW showNotification() jika tersedia
        if (navigator.serviceWorker && navigator.serviceWorker.controller) {
            navigator.serviceWorker.ready.then(reg => {
                reg.showNotification('Update Pesananmu! ☕', {
                    body: `Status pesanan: ${statusLabel}`,
                    icon: '/images/icons/icon-192x192.png',
                });
            });
        } else {
            // Fallback untuk desktop / browser lain
            try {
                new Notification('Update Pesananmu! ☕', {
                    body: `Status pesanan: ${statusLabel}`,
                    icon: '/images/icons/icon-192x192.png',
                });
            } catch (e) {
                console.log('[Notif] Tidak didukung:', e.message);
            }
        }
    };

    if (Notification.permission === 'granted') {
        show();
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(p => { if (p === 'granted') show(); });
    }
}
