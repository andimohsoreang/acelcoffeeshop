// ============================================================
// FILE: resources/js/admin-notifications.js
// Realtime order notifications untuk admin panel via Laravel Reverb
// ============================================================

export default class AdminNotifications {
    constructor() {
        this.audioCtx = null;
        this.newOrderCount = 0;
        this.init();
    }

    init() {
        if (!window.Echo) {
            console.warn('[Reverb] Echo belum siap, notifikasi admin tidak aktif.');
            return;
        }

        console.log('[Reverb] Listening on channel: admin-orders');

        window.Echo.channel('admin-orders')
            .listen('.order.placed', (data) => {
                console.log('[Reverb] order.placed received:', data);
                this.handleNewOrder(data);
            })
            .listen('.order.status.updated', (data) => {
                console.log('[Reverb] order.status.updated received:', data);
                this.handleStatusUpdate(data);
            });
    }

    // ============================================================
    // Handle order baru masuk
    // ============================================================
    handleNewOrder(order) {
        this.newOrderCount++;
        this.updateBadge();
        this.playSound();
        this.showToast(
            `🛎️ Order Baru! #${order.queue_number}`,
            `${order.customer_name} — ${this.formatPrice(order.total_amount)}`,
            'success'
        );
        this.prependOrderToTable(order);
        document.title = `(${this.newOrderCount}) Order Baru — Admin`;
    }

    // ============================================================
    // Handle update status order — live update badge di tabel
    // ============================================================
    handleStatusUpdate(order) {
        const row = document.querySelector(`tr[data-order-id="${order.id}"]`);
        if (!row) return;

        const statusBadge = row.querySelector('.status-badge');
        if (!statusBadge) return;

        // Hapus class badge-status-* lama
        const oldClass = Array.from(statusBadge.classList).find(c => c.startsWith('badge-status-'));
        if (oldClass) statusBadge.classList.remove(oldClass);
        statusBadge.classList.add(`badge-status-${order.status}`);
        statusBadge.dataset.status = order.status;

        // Reset inner content
        const pulseDot = statusBadge.querySelector('.pulse-dot');
        if (pulseDot) pulseDot.remove();

        // Text node baru
        const textNode = Array.from(statusBadge.childNodes).find(n => n.nodeType === Node.TEXT_NODE);
        const newText = order.status.replace('_', ' ');
        if (textNode) {
            textNode.textContent = newText;
        } else {
            statusBadge.appendChild(document.createTextNode(newText));
        }

        // Pulse dot untuk pending
        if (order.status === 'pending') {
            const dot = document.createElement('span');
            dot.className = 'pulse-dot';
            dot.style.cssText = 'width:5px;height:5px;border-radius:50%;background:#f59e0b;margin-right:6px;animation:pulse 2s cubic-bezier(0.4,0,0.6,1) infinite;';
            statusBadge.prepend(dot);
        }

        // Flash row kuning sebentar
        row.style.background = '#fefce8';
        setTimeout(() => row.style.background = 'transparent', 2000);

        this.showToast(
            `📦 Status Diperbarui`,
            `Order #${order.order_code} → ${order.status_label}`,
            'info'
        );
    }

    // ============================================================
    // Update badge counter di sidebar
    // ============================================================
    updateBadge() {
        const badge = document.getElementById('order-notification-badge');
        if (!badge) return;

        const current = parseInt(badge.textContent) || 0;
        badge.textContent = current + 1;
        badge.classList.remove('hidden');
        badge.style.display = 'inline-flex';
        badge.style.transition = 'transform 0.2s';
        badge.style.transform = 'scale(1.35)';
        setTimeout(() => badge.style.transform = 'scale(1)', 200);
    }

    // ============================================================
    // Notif sound via Web Audio API (tidak butuh file audio)
    // ============================================================
    playSound() {
        try {
            if (!this.audioCtx) {
                this.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            const osc = this.audioCtx.createOscillator();
            const gain = this.audioCtx.createGain();
            osc.connect(gain);
            gain.connect(this.audioCtx.destination);
            osc.frequency.setValueAtTime(880, this.audioCtx.currentTime);
            osc.frequency.setValueAtTime(1100, this.audioCtx.currentTime + 0.1);
            osc.frequency.setValueAtTime(880, this.audioCtx.currentTime + 0.2);
            gain.gain.setValueAtTime(0.25, this.audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, this.audioCtx.currentTime + 0.6);
            osc.start(this.audioCtx.currentTime);
            osc.stop(this.audioCtx.currentTime + 0.6);
        } catch (e) {
            console.log('Audio not available:', e);
        }
    }

    // ============================================================
    // Toast notification
    // ============================================================
    showToast(title, message, type = 'info') {
        if (typeof window.showToast === 'function') {
            window.showToast(title, message, type);
        }
    }

    // ============================================================
    // Prepend row order baru ke tabel
    // Struktur 6 kolom sesuai admin/orders/index.blade.php
    // ============================================================
    prependOrderToTable(order) {
        const tbody = document.getElementById('orders-tbody');
        if (!tbody) return;

        const orderUrl = `/admin/orders/${order.id}`;
        let typeBg, typeColor, typeText;
        if (order.order_type === 'dine_in') {
            typeBg = '#f1f5f9'; typeColor = '#475569'; typeText = 'Dine In';
        } else if (order.order_type === 'delivery') {
            typeBg = '#fdf4ff'; typeColor = '#c026d3'; typeText = 'Delivery';
        } else {
            typeBg = '#eff6ff'; typeColor = '#3b82f6'; typeText = 'Takeaway';
        }

        const row = document.createElement('tr');
        row.setAttribute('data-order-id', order.id);
        row.style.cssText = 'border-bottom:1px solid #f8fafc;background:#fefce8;';
        row.addEventListener('mouseover', () => row.style.background = '#fafafa');
        row.addEventListener('mouseout', () => row.style.background = 'transparent');

        row.innerHTML = `
            <td style="padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">#${order.order_code}</p>
                    <span style="font-size:9px;font-weight:800;color:#d97706;background:#fde68a;padding:2px 6px;border-radius:4px;text-transform:uppercase;letter-spacing:0.05em;animation:pulse 2s infinite;">Baru</span>
                </div>
                <p style="font-size:11px;color:#64748b;margin:3px 0 0;">Baru saja</p>
                <p style="font-size:10px;color:#d97706;margin:1px 0 0;font-weight:600;">Antrian ${order.queue_number}</p>
            </td>
            <td style="padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle;">
                <p style="font-size:13px;font-weight:600;color:#1e293b;margin:0;">${order.customer_name}</p>
            </td>
            <td style="padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle;">
                <span style="display:inline-flex;align-items:center;padding:2px 8px;border-radius:6px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;background:${typeBg};color:${typeColor};">
                    ${typeText}
                </span>
            </td>
            <td style="padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle;text-align:right;">
                <span style="font-size:13px;font-weight:700;color:#1e293b;">${this.formatPrice(order.total_amount)}</span>
            </td>
            <td style="padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle;text-align:center;">
                <span class="status-badge badge-status-pending" data-status="pending"
                    style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;background:#fffbeb;color:#d97706;border:1px solid #fde68a;">
                    <span class="pulse-dot" style="width:5px;height:5px;border-radius:50%;background:#f59e0b;margin-right:6px;animation:pulse 2s cubic-bezier(0.4,0,0.6,1) infinite;"></span>
                    pending
                </span>
            </td>
            <td style="padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle;text-align:center;">
                <a href="${orderUrl}"
                    style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#eff6ff;color:#3b82f6;text-decoration:none;"
                    title="Detail Order">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </a>
            </td>
        `;

        tbody.insertBefore(row, tbody.firstChild);
        setTimeout(() => row.style.background = 'transparent', 4000);
    }

    // ============================================================
    // Format harga ke Rupiah
    // ============================================================
    formatPrice(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }
}
