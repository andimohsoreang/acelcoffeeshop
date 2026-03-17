<x-layouts.admin>
    <x-slot:title>Kelola Pesanan</x-slot:title>
    <x-slot:subtitle>Daftar seluruh pesanan yang masuk</x-slot:subtitle>

    <style>
        .order-card { background:#fff; border-radius:14px; border:1px solid #e8edf2; box-shadow:0 1px 3px rgba(0,0,0,0.05); }
        .filter-input { display:block;width:100%;padding:8px 11px;border-radius:8px;border:1.5px solid #e2e8f0;font-size:13px;color:#1e293b;outline:none;background:#fff;transition:border-color .15s;box-sizing:border-box; }
        .filter-input:focus { border-color:#3b82f6; }
        .filter-label { display:block;font-size:10px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px; }
        
        .btn-filter { display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:10px;border-radius:9px;background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;font-size:13px;font-weight:600;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(59,130,246,.25);transition:opacity .15s; }
        .btn-filter:hover { opacity:.9; }
        .btn-reset { display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:9px;background:#fef2f2;color:#ef4444;border:1px solid #fecaca;cursor:pointer;transition:all .15s;text-decoration:none;flex-shrink:0;}
        .btn-reset:hover { background:#fee2e2; }

        .badge-status-pending { background:#fffbeb; color:#d97706; border:1px solid #fde68a; }
        .badge-status-confirmed { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
        .badge-status-in_progress { background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; }
        .badge-status-ready { background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; }
        .badge-status-completed { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
        .badge-status-cancelled { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        
        .badge-type-dine_in { background:#f1f5f9; color:#475569; }
        .badge-type-takeaway { background:#eff6ff; color:#3b82f6; }
        .badge-type-delivery { background:#fdf4ff; color:#c026d3; }

        .table-th { padding:10px 16px;text-align:left;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #f1f5f9; }
        .table-td { padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle; }
        .action-btn { display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:transparent;color:#94a3b8;text-decoration:none;transition:all .15s;border:none;cursor:pointer; }
        .action-btn:hover { background:#eff6ff;color:#3b82f6; }
    </style>

    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Filter Section --}}
        <div class="order-card" style="padding:18px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid #f1f5f9;">
                <div style="width:30px;height:30px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:14px;height:14px;color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">Filter Pesanan</p>
                    <p style="font-size:11px;color:#94a3b8;margin:0;">Temukan pesanan spesifik dengan cepat</p>
                </div>
            </div>

            <form action="{{ route('admin.orders.index') }}" method="GET" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">
                
                {{-- Per Baris --}}
                <div style="width:100px;flex-shrink:0;">
                    <label class="filter-label">Baris</label>
                    <select name="per_page" class="filter-input" onchange="this.form.submit()" style="padding-right:24px;appearance:none;background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5%22%20fill%3D%22none%22%20stroke%3D%22%2394A3B8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E');background-repeat:no-repeat;background-position:right 8px center;background-size:16px;">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>

                <div style="flex:1;min-width:240px;">
                    <label class="filter-label">Pencarian</label>
                    <div style="position:relative;">
                        <svg style="width:14px;height:14px;color:#94a3b8;position:absolute;left:12px;top:50%;transform:translateY(-50%);point-events:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" class="filter-input" style="padding-left:34px;" placeholder="No Order, Nama, HP...">
                    </div>
                </div>
                
                <div style="width:150px;flex-shrink:0;">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input" style="padding-right:24px;appearance:none;background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5%22%20fill%3D%22none%22%20stroke%3D%22%2394A3B8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E');background-repeat:no-repeat;background-position:right 8px center;background-size:16px;">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div style="width:130px;flex-shrink:0;">
                    <label class="filter-label">Tipe</label>
                    <select name="order_type" class="filter-input" style="padding-right:24px;appearance:none;background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5%22%20fill%3D%22none%22%20stroke%3D%22%2394A3B8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E');background-repeat:no-repeat;background-position:right 8px center;background-size:16px;">
                        <option value="">Semua</option>
                        <option value="dine_in" {{ request('order_type') == 'dine_in' ? 'selected' : '' }}>Dine-in</option>
                        <option value="takeaway" {{ request('order_type') == 'takeaway' ? 'selected' : '' }}>Takeaway</option>
                        <option value="delivery" {{ request('order_type') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                    </select>
                </div>

                <div style="display:flex;align-items:center;gap:8px;width:100%;@media(min-width:768px){width:auto;}">
                    <button type="submit" class="btn-filter" style="flex:1;@media(min-width:768px){width:110px;flex:none;height:40px;}">Filter</button>
                    @if(request()->anyFilled(['search', 'status', 'order_type', 'date']))
                        <a href="{{ route('admin.orders.index') }}" class="btn-reset" title="Reset">✕</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table Section --}}
        <div class="order-card" style="display:flex;flex-direction:column;">
            <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;background:#fafafa;">
                <div>
                    <h3 style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">Daftar Pesanan</h3>
                    <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">Menampilkan antrean transaksi</p>
                </div>
                <span style="padding:3px 10px;background:#f1f5f9;color:#64748b;border-radius:99px;font-size:11px;font-weight:600;">{{ $orders->total() }} Pesanan</span>
            </div>

            <div style="flex:1;overflow-x:auto;">
                <table style="width:100%;min-width:800px;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th class="table-th">Order & Waktu</th>
                            <th class="table-th">Pelanggan</th>
                            <th class="table-th">Tipe Tagihan</th>
                            <th class="table-th text-right">Total</th>
                            <th class="table-th text-center">Status</th>
                            <th class="table-th text-center" style="width:60px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="orders-tbody">
                        @forelse($orders as $order)
                        @php
                            $isNew = $order->status === 'pending' && $order->created_at->diffInMinutes(now()) <= 30;
                            $rowBg = $isNew ? '#fffbeb' : 'transparent';
                            $rowHoverBg = $isNew ? '#fef3c7' : '#fafafa';
                        @endphp
                        <tr data-order-id="{{ $order->id }}" style="border-bottom:1px solid #f8fafc;background:{{ $rowBg }};transition:background 0.2s;" onmouseover="this.style.background='{{ $rowHoverBg }}'" onmouseout="this.style.background='{{ $rowBg }}'">
                            <td class="table-td">
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">#{{ $order->order_code }}</p>
                                    @if($isNew)
                                        <span style="font-size:9px;font-weight:800;color:#d97706;background:#fde68a;padding:2px 6px;border-radius:4px;text-transform:uppercase;letter-spacing:0.05em;animation:pulse 2s infinite;">Baru</span>
                                    @endif
                                </div>
                                <p style="font-size:11px;color:#64748b;margin:3px 0 0;">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                <p style="font-size:10px;color:{{ $isNew ? '#d97706' : '#cbd5e1' }};margin:1px 0 0;font-weight:{{ $isNew ? '600' : 'normal' }};">{{ $order->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="table-td">
                                <p style="font-size:13px;font-weight:600;color:#1e293b;margin:0;">{{ $order->customer_name }}</p>
                                <p style="font-size:11px;color:#64748b;margin:3px 0 0;display:flex;align-items:center;gap:4px;">
                                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $order->customer_phone ?? '-' }}
                                </p>
                            </td>
                            <td class="table-td">
                                <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                                    <span class="badge-type-{{ strtolower($order->order_type) }}" style="display:inline-flex;align-items:center;padding:2px 8px;border-radius:6px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
                                        {{ str_replace('_', ' ', $order->order_type) }}
                                    </span>
                                </div>
                                <div style="display:flex;align-items:center;gap:4px;font-size:11px;font-weight:500;color:#64748b;">
                                    @if($order->payment_method === 'cash')
                                        <svg style="width:13px;height:13px;color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        Tunai
                                    @else
                                        <svg style="width:13px;height:13px;color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                        Transfer ({{ strtoupper($order->payment?->status ?? 'Unpaid') }})
                                    @endif
                                </div>
                            </td>
                            <td class="table-td text-right">
                                <span style="font-size:13px;font-weight:700;color:#1e293b;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="table-td text-center">
                                <span class="status-badge badge-status-{{ $order->status }}" data-status="{{ $order->status }}" style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
                                    @if($order->status == 'pending')
                                        <span class="pulse-dot" style="width:5px;height:5px;border-radius:50%;background:#f59e0b;margin-right:6px;animation:pulse 2s cubic-bezier(0.4,0,0.6,1) infinite;"></span>
                                    @endif
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                            <td class="table-td text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" class="action-btn" title="Detail Order">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding:44px 20px;text-align:center;">
                                <svg style="width:36px;height:36px;color:#e2e8f0;margin:0 auto 10px;display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                <p style="font-size:13px;font-weight:600;color:#64748b;margin:0;">Tidak ada pesanan ditemukan</p>
                                @if(request()->anyFilled(['search', 'status', 'order_type']))
                                    <a href="{{ route('admin.orders.index') }}" style="font-size:12px;color:#3b82f6;text-decoration:none;margin-top:6px;display:inline-block;">Hapus semua filter</a>
                                @endif
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
