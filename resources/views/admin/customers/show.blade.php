<x-layouts.admin>
    <x-slot:title>Profil Pelanggan</x-slot:title>
    <x-slot:subtitle>Rekam jejak transaksi & histori order untuk: {{ $customer->customer_phone }}</x-slot:subtitle>

    <style>
        .order-card { background:#fff; border-radius:14px; border:1px solid #e8edf2; box-shadow:0 1px 3px rgba(0,0,0,0.05); }
        .table-th { padding:10px 16px;text-align:left;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #f1f5f9; }
        .table-td { padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle; font-size:13px; color:#1e293b; font-weight:500; }
        .badge-status-pending { background:#fffbeb; color:#d97706; border:1px solid #fde68a; }
        .badge-status-confirmed { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
        .badge-status-in_progress { background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; }
        .badge-status-ready { background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; }
        .badge-status-completed { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
        .badge-status-cancelled { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        
        .badge-type-dine_in { background:#f1f5f9; color:#475569; }
        .badge-type-takeaway { background:#eff6ff; color:#3b82f6; }
        .badge-type-delivery { background:#fdf4ff; color:#c026d3; }
        
        .action-btn { display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:transparent;color:#94a3b8;text-decoration:none;transition:all .15s;border:none;cursor:pointer; }
        .action-btn:hover { background:#eff6ff;color:#3b82f6; }
    </style>

    <div style="display:flex;flex-direction:column;gap:16px;">
        {{-- Section Profil --}}
        <div class="order-card" style="padding:18px;display:flex;gap:20px;flex-wrap:wrap;align-items:center;">
            <div style="width:50px;height:50px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:bold;flex-shrink:0;">
                {{ strtoupper(substr($customer->customer_name, 0, 1)) }}
            </div>
            <div style="flex:1;min-width:200px;">
                <h3 style="margin:0;font-size:18px;font-weight:800;color:#1e293b;">{{ $customer->customer_name }}</h3>
                <p style="margin:4px 0 0;font-size:13px;color:#64748b;font-weight:600;display:flex;align-items:center;gap:6px;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $customer->customer_phone }} 
                    <span style="display:inline-block;padding:2px 8px;border-radius:6px;background:#f1f5f9;color:#475569;font-size:10px;margin-left:8px;">Terdaftar Histori {{ \Carbon\Carbon::parse($customer->last_order_date)->format('Y') }}</span>
                </p>
            </div>
            
            <div style="display:flex;gap:16px;border-left:1px solid #f1f5f9;padding-left:20px;">
                <div>
                    <p style="margin:0;font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;">Total Transaksi</p>
                    <p style="margin:2px 0 0;font-size:18px;font-weight:800;color:#1e293b;">{{ $customer->total_orders }} <span style="font-size:12px;color:#64748b;">Pesanan</span></p>
                </div>
                <div>
                    <p style="margin:0;font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;">Lifetime Value</p>
                    <p style="margin:2px 0 0;font-size:18px;font-weight:800;color:#1e293b;">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.customers.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;border:1px solid #e2e8f0;color:#475569;font-size:12px;font-weight:600;text-decoration:none;margin-left:auto;background:#fff;transition:background .15s;">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        {{-- Table Riwayat Status --}}
        <div class="order-card" style="display:flex;flex-direction:column;">
            <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;background:#fafafa;">
                <div>
                    <h3 style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">Kumpulan Histori Transaksi</h3>
                    <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">Semua order yang pernah dibuat atas nama atau nomor hp ini</p>
                </div>
            </div>

            <div style="flex:1;overflow-x:auto;">
                <table style="width:100%;min-width:800px;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th class="table-th">Waktu Order</th>
                            <th class="table-th">No. Pesanan</th>
                            <th class="table-th">Tipe & Jenis Pembayaran</th>
                            <th class="table-th text-center">Status Pemesanan</th>
                            <th class="table-th text-right">Nilai Belanja</th>
                            <th class="table-th text-center" style="width:60px;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr style="border-bottom:1px solid #f8fafc;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                            <td class="table-td">
                                <span style="font-size:13px;font-weight:700;">{{ $order->created_at->format('d M Y') }}</span>
                                <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">{{ $order->created_at->format('H:i') }} WIB</p>
                            </td>
                            <td class="table-td text-primary font-bold">
                                #{{ $order->order_code }}
                            </td>
                            <td class="table-td">
                                <span class="badge-type-{{ strtolower($order->order_type) }}" style="display:inline-flex;align-items:center;padding:2px 8px;border-radius:6px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">
                                    {{ str_replace('_', ' ', $order->order_type) }}
                                </span>
                                <div style="display:flex;align-items:center;gap:4px;font-size:11px;font-weight:500;color:#64748b;">
                                    @if($order->payment_method === 'cash')
                                        Tunai
                                    @else
                                        Transfer ({{ strtoupper($order->payment?->status ?? 'Unpaid') }})
                                    @endif
                                </div>
                            </td>
                            <td class="table-td text-center">
                                <span class="badge-status-{{ $order->status }}" style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                            <td class="table-td text-right">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="table-td text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" class="action-btn" title="Cek Detail Order">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding:44px 20px;text-align:center;">
                                <p style="font-size:13px;font-weight:600;color:#64748b;margin:0;">Oops, tidak ada riwayat pesanan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination footer --}}
            <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; padding:12px 16px; border-top:1px solid #e2e8f0; background:#f8fafc;">
                <p style="font-size:12px; color:#64748b; margin:0;">
                    Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan
                </p>
                @if($orders->hasPages())
                <div style="display:flex; align-items:center; gap:4px;">
                    @if($orders->onFirstPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">‹</span>
                    @else
                    <a href="{{ $orders->previousPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; text-decoration:none; background:#fff;">‹</a>
                    @endif

                    @foreach ($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
                    @if($page == $orders->currentPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; background:linear-gradient(135deg,#3b82f6,#2563eb); color:#fff; font-size:13px; font-weight:600;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; background:#fff; font-size:13px; text-decoration:none;">{{ $page }}</a>
                    @endif
                    @endforeach

                    @if($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; background:#fff; text-decoration:none;">›</a>
                    @else
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">›</span>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
