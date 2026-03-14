<x-layouts.admin>
    <x-slot:title>Daftar Pelanggan</x-slot:title>
    <x-slot:subtitle>Rekapitulasi loyalitas berdasarkan riwayat nomor telepon</x-slot:subtitle>

    <style>
        .order-card { background:#fff; border-radius:14px; border:1px solid #e8edf2; box-shadow:0 1px 3px rgba(0,0,0,0.05); }
        .filter-input { display:block;width:100%;padding:8px 11px;border-radius:8px;border:1.5px solid #e2e8f0;font-size:13px;color:#1e293b;outline:none;background:#fff;transition:border-color .15s;box-sizing:border-box; }
        .filter-input:focus { border-color:#3b82f6; }
        .filter-label { display:block;font-size:10px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px; }
        
        .btn-filter { display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:10px;border-radius:9px;background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;font-size:13px;font-weight:600;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(59,130,246,.25);transition:opacity .15s; }
        .btn-filter:hover { opacity:.9; }
        .btn-reset { display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:9px;background:#fef2f2;color:#ef4444;border:1px solid #fecaca;cursor:pointer;transition:all .15s;text-decoration:none;flex-shrink:0;}
        .btn-reset:hover { background:#fee2e2; }

        .table-th { padding:10px 16px;text-align:left;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #f1f5f9; }
        .table-td { padding:14px 16px;border-bottom:1px solid #f8fafc;vertical-align:middle; }
        .action-btn { display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:transparent;color:#94a3b8;text-decoration:none;transition:all .15s;border:none;cursor:pointer; }
        .action-btn:hover { background:#eff6ff;color:#3b82f6; }

        .badge-vvip { background:linear-gradient(135deg,#f59e0b,#ea580c); color:#fff; border:none; box-shadow:0 2px 5px rgba(245,158,11,.3); }
        .badge-loyal { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
        .badge-newbie { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    </style>

    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Filter Section --}}
        <div class="order-card" style="padding:18px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid #f1f5f9;">
                <div style="width:30px;height:30px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:14px;height:14px;color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">Filter Pelanggan</p>
                    <p style="font-size:11px;color:#94a3b8;margin:0;">Cari database nomor HP pelanggan</p>
                </div>
            </div>

            <form action="{{ route('admin.customers.index') }}" method="GET" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">
                
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
                    <label class="filter-label">Pencarian Database</label>
                    <div style="position:relative;">
                        <svg style="width:14px;height:14px;color:#94a3b8;position:absolute;left:12px;top:50%;transform:translateY(-50%);point-events:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" class="filter-input" style="padding-left:34px;" placeholder="Ketik Nama Terakhir atau Nomor HP Pelanggan...">
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:8px;width:100%;@media(min-width:768px){width:auto;}">
                    <button type="submit" class="btn-filter" style="flex:1;@media(min-width:768px){width:110px;flex:none;height:40px;}">Filter</button>
                    @if(request()->anyFilled(['search']))
                        <a href="{{ route('admin.customers.index') }}" class="btn-reset" title="Reset">✕</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table Section --}}
        <div class="order-card" style="display:flex;flex-direction:column;">
            <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;background:#fafafa;">
                <div>
                    <h3 style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">Catatan Loyalitas Nasabah</h3>
                    <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">Di-generasi otomais melalui agregat riwayat Orders (Transaksi Gagal tidak dihitung)</p>
                </div>
                <span style="padding:3px 10px;background:#f1f5f9;color:#64748b;border-radius:99px;font-size:11px;font-weight:600;">Total: {{ $customers->total() }} Nasabah</span>
            </div>

            <div style="flex:1;overflow-x:auto;">
                <table style="width:100%;min-width:800px;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th class="table-th" style="width: 50px; text-align:center;">#</th>
                            <th class="table-th">Identitas Utama</th>
                            <th class="table-th text-center">Kelas Loyalitas</th>
                            <th class="table-th text-center">Frekuensi Beli</th>
                            <th class="table-th text-right">Lifetime Value (Pengeluaran)</th>
                            <th class="table-th text-center" style="width:60px;">Histori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $index => $customer)
                        <tr style="border-bottom:1px solid #f8fafc;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                            <td class="table-td text-center">
                                <span style="font-size:11px;font-weight:600;color:#94a3b8;">{{ $customers->firstItem() + $index }}</span>
                            </td>
                            <td class="table-td">
                                <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">{{ $customer->customer_name }}</p>
                                <p style="font-size:11px;color:#64748b;margin:3px 0 0;display:flex;align-items:center;gap:4px;">
                                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $customer->customer_phone }}
                                </p>
                            </td>
                            <td class="table-td text-center">
                                @if($customer->total_spent >= 1000000 || $customer->total_orders >= 10)
                                    <span class="badge-vvip" style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
                                        👑 VIP SULTAN
                                    </span>
                                @elseif($customer->total_orders >= 3)
                                    <span class="badge-loyal" style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
                                        ⭐ LOYAL PELANGGAN
                                    </span>
                                @else
                                    <span class="badge-newbie" style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
                                        🆕 PENGUNJUNG BARU
                                    </span>
                                @endif
                            </td>
                            <td class="table-td text-center">
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:24px;height:24px;border-radius:6px;background:#f1f5f9;color:#475569;font-size:11px;font-weight:700;">{{ $customer->total_orders }}x</span>
                            </td>
                            <td class="table-td text-right">
                                <span style="font-size:14px;font-weight:800;color:#1e293b;">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</span>
                                <p style="font-size:10px;color:#94a3b8;margin:2px 0 0;">Last: {{ \Carbon\Carbon::parse($customer->last_order_date)->translatedFormat('d M, Y') }}</p>
                            </td>
                            <td class="table-td text-center">
                                <a href="{{ route('admin.customers.show', $customer->customer_phone) }}" class="action-btn" title="Lihat Rekam Jejak Belanja">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding:44px 20px;text-align:center;">
                                <svg style="width:36px;height:36px;color:#e2e8f0;margin:0 auto 10px;display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <p style="font-size:13px;font-weight:600;color:#64748b;margin:0;">Tidak ada rekap nomor pelanggan ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination footer --}}
            <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; padding:12px 16px; border-top:1px solid #e2e8f0; background:#f8fafc;">
                <p style="font-size:12px; color:#64748b; margin:0;">
                    Menampilkan {{ $customers->firstItem() ?? 0 }}–{{ $customers->lastItem() ?? 0 }} dari {{ $customers->total() }} pelanggan
                </p>
                @if($customers->hasPages())
                <div style="display:flex; align-items:center; gap:4px;">
                    @if($customers->onFirstPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">‹</span>
                    @else
                    <a href="{{ $customers->previousPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; text-decoration:none; background:#fff;">‹</a>
                    @endif

                    @foreach ($customers->getUrlRange(max(1, $customers->currentPage() - 2), min($customers->lastPage(), $customers->currentPage() + 2)) as $page => $url)
                    @if($page == $customers->currentPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; background:linear-gradient(135deg,#3b82f6,#2563eb); color:#fff; font-size:13px; font-weight:600;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; background:#fff; font-size:13px; text-decoration:none;">{{ $page }}</a>
                    @endif
                    @endforeach

                    @if($customers->hasMorePages())
                    <a href="{{ $customers->nextPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; background:#fff; text-decoration:none;">›</a>
                    @else
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">›</span>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
