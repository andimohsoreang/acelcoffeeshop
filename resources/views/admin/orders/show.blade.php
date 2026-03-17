<x-layouts.admin>
    <x-slot:title>Detail Pesanan</x-slot:title>
    <x-slot:subtitle>Informasi keranjang, biodata, dan aksi status pelanggan</x-slot:subtitle>

    <style>
        .order-card { background:#fff; border-radius:14px; border:1px solid #e8edf2; box-shadow:0 1px 3px rgba(0,0,0,0.05); }
        .info-label { display:block;font-size:10px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px; }
        .info-value { font-size:13px;font-weight:600;color:#1e293b;margin:0; }
        
        .badge-status-pending { background:#fef3c7; color:#b45309; border:1px solid #fde68a; }
        .badge-status-confirmed { background:#e0e7ff; color:#4338ca; border:1px solid #c7d2fe; }
        .badge-status-in_progress { background:#dbeafe; color:#1d4ed8; border:1px solid #bfdbfe; }
        .badge-status-ready { background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; }
        .badge-status-completed { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
        .badge-status-cancelled { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }

        .btn-update { display:inline-flex;align-items:center;justify-content:center;padding:10px 16px;border-radius:8px;background:#3b82f6;color:#fff;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:all .15s; }
        .btn-update:hover { opacity:.9; }
        .btn-update:disabled { background:#cbd5e1;cursor:not-allowed; }
        
        .btn-cancel { display:inline-flex;align-items:center;justify-content:center;padding:10px 16px;border-radius:8px;background:#fff;color:#ef4444;border:1px solid #fca5a5;font-size:13px;font-weight:600;cursor:pointer;transition:all .15s; }
        .btn-cancel:hover { background:#fef2f2; }
        
        .timeline-item { position:relative;padding-left:24px;padding-bottom:16px; }
        .timeline-item::before { content:'';position:absolute;left:4px;top:20px;bottom:-10px;width:1.5px;background:#e2e8f0; }
        .timeline-item:last-child::before { display:none; }
        .timeline-dot { position:absolute;left:0;top:-2px;width:10px;height:10px;border-radius:50%;background:#e2e8f0;border:2px solid #fff; }
        .timeline-dot.active { background:#3b82f6;box-shadow:0 0 0 2px rgba(59,130,246,.2); }
    </style>

    <div class="mb-5 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900 inline-flex items-center gap-2">
                    Order #{{ $order->order_code }}
                    <span class="px-2.5 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold badge-status-{{ $order->status }}">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                </h1>
                <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->format('l, d F Y - H:i') }}</p>
            </div>
        </div>
        
        {{-- Cetak Struk (Optional) --}}
        <button onclick="window.print()" class="hidden md:inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Struk
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 relative">
        {{-- BAGIAN KIRI (DETAIL KERANJANG & PELANGGAN) --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Biodata Pelanggan --}}
            <div class="order-card p-5 lg:p-6">
                <h2 class="text-sm font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Informasi Pelanggan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-6">
                    <div>
                        <span class="info-label">Nama Pelanggan</span>
                        <p class="info-value">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <span class="info-label">No. WhatsApp / Telepon</span>
                        <p class="info-value">{{ $order->customer_phone ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="info-label">Tipe Pesanan</span>
                        <p class="info-value capitalize">{{ str_replace('_', ' ', $order->order_type) }}</p>
                    </div>
                    @if($order->order_type === 'delivery')
                    <div class="md:col-span-2">
                        <span class="info-label">Alamat Pengiriman Lengkap</span>
                        <p class="info-value text-gray-700 font-normal leading-relaxed rounded-lg p-3 bg-gray-50 border border-gray-100 mt-1">
                            {{ $order->shipping_address ?? 'Tidak ada riwayat alamat' }}
                        </p>
                    </div>
                    @endif
                    <div class="md:col-span-2">
                        <span class="info-label">Catatan Tambahan Transaksi</span>
                        <p class="info-value text-gray-600 font-normal mt-1">{{ $order->notes ?? 'Tidak ada pesanan / request tambahan.' }}</p>
                    </div>
                </div>
            </div>

            {{-- Detail Produk --}}
            <div class="order-card overflow-hidden">
                <div class="p-5 lg:p-6 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Rincian Belanja
                    </h2>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $order->items->count() }} Jenis Menu</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">Produk</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 text-center">Harga</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 text-center">Qty</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($order->items as $item)
                            <tr class="hover:bg-gray-50/30">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-md bg-gray-100 border border-gray-200 flex-shrink-0 overflow-hidden">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-sm">{{ $item->product_name }}</p>
                                            @if($item->product && $item->product->category)
                                                <p class="text-[10px] text-gray-500">{{ $item->product->category->name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="w-6 h-6 inline-flex items-center justify-center bg-gray-100 text-gray-600 font-bold rounded text-xs">{{ $item->quantity }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-600 text-sm">Total Belanja:</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-lg font-black text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            {{-- Konfirmasi Pembayaran (metode-spesifik) --}}
            <div class="order-card p-5 lg:p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Konfirmasi Pembayaran
                    </h2>
                    @if($order->payment)
                        @if($order->payment->status === 'verified')
                            <span class="px-3 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-200">✅ TERVERIFIKASI</span>
                        @elseif($order->payment->status === 'rejected')
                            <span class="px-3 py-1 rounded bg-red-50 text-red-600 text-[10px] font-bold border border-red-200">❌ DITOLAK</span>
                        @else
                            <span class="px-3 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-bold border border-amber-200">⏳ MENUNGGU KONFIRMASI</span>
                        @endif
                    @else
                        <span class="px-3 py-1 rounded bg-gray-100 text-gray-500 text-[10px] font-bold border border-gray-200">BELUM ADA DATA</span>
                    @endif
                </div>

                @if($order->payment)
                    {{-- Info Metode Pembayaran --}}
                    <div class="flex items-center gap-3 p-3 rounded-xl mb-4
                        {{ $order->payment->method === 'cash' ? 'bg-green-50 border border-green-100' : 'bg-purple-50 border border-purple-100' }}">
                        @if($order->payment->method === 'cash')
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-green-800">Pembayaran Tunai / Debit</p>
                                <p class="text-[10px] text-green-600 mt-0.5">Customer membayar langsung di kasir. Konfirmasi setelah menerima uang/kartu.</p>
                            </div>
                            @else                            <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-purple-800">QRIS</p>
                                <p class="text-[10px] text-purple-600 mt-0.5">Cek notifikasi masuk dari aplikasi QRIS/bank. Konfirmasi setelah pembayaran terdeteksi.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Detail Payment --}}
                    <div class="grid grid-cols-2 gap-3 mb-4 text-xs">
                        <div>
                            <span class="info-label">Total Tagihan</span>
                            <p class="info-value text-blue-600">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <span class="info-label">Waktu Order</span>
                            <p class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    {{-- Status Ditolak --}}
                    @if($order->payment->status === 'rejected')
                    <div class="p-3 bg-red-50 border border-red-100 rounded-lg mb-4">
                        <span class="info-label text-red-800">Alasan Penolakan</span>
                        <p class="text-xs text-red-600 font-semibold mt-1">{{ $order->payment->reject_reason ?? 'Tidak ada keterangan.' }}</p>
                        <p class="text-[10px] text-red-500 mt-1">Customer perlu melakukan pemesanan ulang.</p>
                    </div>
                    @endif

                    {{-- Aksi Konfirmasi (hanya jika belum verified dan order aktif) --}}
                    @if(in_array($order->payment->status, ['pending', 'uploaded']) && !$order->isFinished())
                    <div class="flex flex-col gap-2 pt-3 border-t border-gray-100">

                        {{-- Tombol Konfirmasi berbeda per metode --}}
                        <form action="{{ route('admin.orders.payment.verify', $order) }}" method="POST">
                            @csrf @method('PATCH')
                            @if($order->payment->method === 'cash')
                                <button type="submit" class="w-full btn-update bg-green-600 hover:bg-green-700 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    ✅ Konfirmasi Pembayaran Tunai
                                </button>
                            @else                                <button type="submit" class="w-full btn-update bg-purple-600 hover:bg-purple-700 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    📱 Verifikasi QRIS
                                </button>
                            @endif
                        </form>

                        {{-- Tombol Tolak --}}
                        <div x-data="{ openReject: false }" class="w-full">
                            <button type="button" @click="openReject = !openReject" class="w-full btn-cancel text-sm">
                                ❌ Tolak Pembayaran
                            </button>
                            <div x-show="openReject" x-transition class="mt-2 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                <form action="{{ route('admin.orders.payment.reject', $order) }}" method="POST" class="flex flex-col gap-3">
                                    @csrf @method('PATCH')
                                    <p class="text-[10px] text-red-600 font-semibold">⚠️ Customer akan diminta melakukan pemesanan ulang.</p>
                                    <textarea name="reason" rows="2" class="filter-input text-xs" placeholder="Tuliskan alasan penolakan (contoh: Pembayaran tidak ditemukan, nominal kurang, dll)..." required></textarea>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="openReject = false" class="text-xs text-gray-500 hover:underline px-2 font-semibold">Batal</button>
                                        <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded-md hover:bg-red-700">Konfirmasi Penolakan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @elseif($order->payment->status === 'verified')
                    <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-lg">
                        <p class="text-[11px] text-emerald-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Telah dikonfirmasi oleh <b>{{ $order->payment->verifiedBy->name ?? 'Admin' }}</b> pada {{ $order->payment->verified_at?->format('H:i, d M Y') }}
                        </p>
                    </div>
                    @endif
                @else
                <div class="text-center py-6 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <p class="text-sm">Data pembayaran belum tersedia.</p>
                </div>
                @endif
            </div>

        </div>


        {{-- BAGIAN KANAN (STATUS UPDATER PANEL) --}}
        <div>
            <div class="order-card p-5 lg:p-6 sticky top-6">
                <h2 class="text-sm font-bold text-gray-900 mb-6 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Pembaruan Proses
                </h2>

                <div class="relative mb-8 px-2">
                    <div class="timeline-item">
                        <div class="timeline-dot {{ in_array($order->status, ['pending', 'confirmed', 'in_progress', 'ready', 'completed']) ? 'active' : '' }}"></div>
                        <h4 class="text-xs font-bold text-gray-900">Menunggu (Pending)</h4>
                        <p class="text-[10px] text-gray-400 mt-0.5">Order ditempatkan nasabah.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot {{ in_array($order->status, ['confirmed', 'in_progress', 'ready', 'completed']) ? 'active' : '' }}"></div>
                        <h4 class="text-xs font-bold text-gray-900">Pembayaran Disetujui (Confirmed)</h4>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $order->confirmed_at ? $order->confirmed_at->format('H:i') : 'Belum diproses' }}</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot {{ in_array($order->status, ['in_progress', 'ready', 'completed']) ? 'active' : '' }}"></div>
                        <h4 class="text-xs font-bold text-gray-900">Dapur (In Progress)</h4>
                        <p class="text-[10px] text-gray-400 mt-0.5">Barista sedang mengolah kopi.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot {{ in_array($order->status, ['ready', 'completed']) ? 'active' : '' }}"></div>
                        <h4 class="text-xs font-bold text-gray-900">Siap Ambil (Ready)</h4>
                        <p class="text-[10px] text-gray-400 mt-0.5">Beritahu nasabah paket siap dipickup / delivery.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot {{ in_array($order->status, ['completed']) ? 'active' : '' }}"></div>
                        <h4 class="text-xs font-bold text-gray-900">Selesai (Completed)</h4>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $order->completed_at ? $order->completed_at->format('d/m/Y H:i') : '' }}</p>
                    </div>
                </div>

                @if(!$order->isFinished())
                <div class="border-t border-gray-100 pt-5 space-y-3">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-col gap-2">
                        @csrf @method('PATCH')
                        <span class="info-label text-blue-600">Perbarui Status Jadi:</span>
                        <select name="status" class="filter-input bg-gray-50 border-gray-200">
                            {{-- Validasi flow agar tidak bisa mundur ada di controller --}}
                            @php
                                $statusFlow = ['pending' => 0, 'confirmed' => 1, 'in_progress' => 2, 'ready' => 3, 'completed' => 4];
                                $currentLevel = $statusFlow[$order->status] ?? 0;
                            @endphp
                            
                            @if($currentLevel <= 1)
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Konfirmasi Order (Confirmed)</option>
                            @endif
                            @if($currentLevel <= 2)
                            <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>Mulai Buat Kopi (In Progress)</option>
                            @endif
                            @if($currentLevel <= 3)
                            <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Makanan Siap (Ready)</option>
                            @endif
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Tutup Order (Completed)</option>
                        </select>
                        <button type="submit" class="btn-update w-full mt-1">Ubah Status</button>
                    </form>

                    {{-- Fitur Pembatalan --}}
                    <div x-data="{ cancelForm: false }" class="mt-4 pt-4 border-t border-gray-100">
                        <button type="button" @click="cancelForm = !cancelForm" class="btn-cancel w-full text-[11px] py-2">
                            Minta Pembatalan Order (Bahan Habis)
                        </button>
                        <div x-show="cancelForm" x-transition class="mt-2 text-xs">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <textarea name="cancel_reason" rows="2" class="filter-input text-xs mb-2" placeholder="Ketikan detail kepada pelanggan kenapa ini dicancel..." required></textarea>
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-1.5 rounded-md">Cancel Permanen</button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="border-t border-gray-100 pt-5">
                    @if($order->status === 'cancelled')
                        <div class="p-3 bg-red-50 border border-red-100 rounded-lg">
                            <h3 class="text-xs font-bold text-red-800 mb-1">Dibatalkan Permanen</h3>
                            <p class="text-[10px] text-red-600">Pelanggan/Sistem telah menolak Order ini.<br>Alasan: {{ $order->cancel_reason ?? 'Tanpa alasan tercatat.' }}</p>
                        </div>
                    @else
                        <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-lg text-center text-emerald-800 font-bold text-xs flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Pesanan Telah Tuntas.
                        </div>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</x-layouts.admin>
