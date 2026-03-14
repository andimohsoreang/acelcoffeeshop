<x-layouts.admin>
    <x-slot:title>Laporan Penjualan</x-slot:title>

    {{-- Filter Panel --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="w-full sm:flex-1">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5" required>
            </div>
            <div class="w-full sm:flex-1">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5" required>
            </div>
            <div class="w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Pendapatan (Verified)</p>
                <p class="text-3xl font-black text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg></div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pesanan Sukses</p>
                <p class="text-3xl font-black text-slate-800">{{ $orders->count() }} Transaksi</p>
            </div>
        </div>
    </div>

    {{-- Table Preview and Actions --}}
    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 overflow-hidden">
        <div class="flex flex-col sm:flex-row items-center justify-between p-6 border-b border-slate-100 bg-slate-50/50 gap-4">
            <div>
                <h2 class="text-base font-black text-slate-800">Pratinjau Data Laporan</h2>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Menampilkan data siap ekspor sesuai filter rentang tanggal.</p>
            </div>
            
            <div class="flex items-center gap-2">
                {{-- Export PDF Button --}}
                <a href="{{ route('admin.reports.exportPdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-xl text-xs font-bold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                    Export PDF
                </a>
                
                {{-- Export Excel Button --}}
                <a href="{{ route('admin.reports.exportExcel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-xs font-bold transition-colors shadow-sm shadow-green-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white">
                        <th class="py-4 pl-6 pr-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Kode</th>
                        <th class="py-4 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Tgl Transaksi</th>
                        <th class="py-4 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Customer (Tipe)</th>
                        <th class="py-4 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Metode Bayar</th>
                        <th class="py-4 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($orders as $order)
                    @php
                        $paymentStatus = $order->payment ? $order->payment->status : 'none';
                        $nominal = ($paymentStatus === 'verified') ? $order->payment->amount : 0;
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 pl-6 pr-4 align-middle font-mono text-[13px] font-bold text-slate-700">#{{ $order->order_code }}</td>
                        <td class="py-3 px-4 align-middle text-[12px] text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-4 align-middle">
                            <p class="text-[13px] font-bold text-slate-800">{{ $order->customer_name }}</p>
                            <span class="text-[10px] text-slate-400">{{ $order->order_type === 'dine_in' ? 'Dine In' : ($order->order_type === 'takeaway' ? 'Takeaway' : 'Delivery') }}</span>
                        </td>
                        <td class="py-3 px-4 align-middle text-center">
                            @if($order->payment)
                                <p class="text-[12px] font-bold text-slate-700">{{ ucfirst($order->payment->method) }}</p>
                                <span class="text-[10px] {{ $paymentStatus === 'verified' ? 'text-green-600' : 'text-amber-500' }}">{{ ucfirst($paymentStatus) }}</span>
                            @else
                                <span class="text-[12px] text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 align-middle text-right text-[13px] font-black {{ $nominal > 0 ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ number_format($nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400 font-medium">Tidak ada data transaksi sukses pada periode terpilih.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
