<x-layouts.admin>
    <x-slot:title>Keuangan</x-slot:title>
    <x-slot:subtitle>Ringkasan performa penjualan dan pendapatan</x-slot:subtitle>

    {{-- Filter Periode --}}
    <div class="mb-8 bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-sm font-semibold text-gray-800">Periode Data</h2>
            <p class="text-xs text-gray-500 mt-0.5">{{ $dateRangeLabel }}</p>
        </div>
        <form method="GET" class="flex flex-wrap items-center gap-2" id="filterForm">
            <select name="period" class="form-input !w-auto text-sm bg-gray-50 border-gray-200"
                x-data @change="
                    if($event.target.value === 'custom') {
                        $refs.customDates.classList.remove('hidden');
                        $refs.customDates.classList.add('flex');
                    } else {
                        $refs.customDates.classList.add('hidden');
                        $refs.customDates.classList.remove('flex');
                        $el.form.submit();
                    }
                ">
                <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ $period === 'week' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Tanggal Kustom</option>
            </select>

            <div x-ref="customDates" class="{{ $period === 'custom' ? 'flex' : 'hidden' }} items-center gap-2">
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-input !w-auto text-sm" max="{{ date('Y-m-d') }}">
                <span class="text-gray-400 text-sm">s/d</span>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-input !w-auto text-sm" max="{{ date('Y-m-d') }}">
                <button type="submit" class="btn-primary py-2 px-3 text-sm">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Summary Cards (KPI) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        {{-- Total Revenue --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pesanan</p>
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">{{ number_format($summary['total_orders']) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Completed Orders --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Pesanan Selesai</p>
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">{{ number_format($summary['completed_orders']) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Average Order Value --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Rata-rata Transaksi</p>
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">Rp {{ number_format($summary['avg_order'], 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Progress Bar: Kategori --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 lg:col-span-1">
            <h3 class="text-base font-bold text-gray-800 mb-6">Pendapatan per Kategori</h3>
            <div class="space-y-5">
                @forelse($byCategory as $cat)
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span>{{ $cat->icon }}</span>
                            <span class="text-sm font-medium text-gray-700">{{ $cat->category_name }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900">Rp {{ number_format($cat->revenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $cat->percentage }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 text-right">{{ $cat->percentage }}% dari total</p>
                </div>
                @empty
                <div class="py-8 text-center text-gray-400">
                    <p class="text-sm">Belum ada data pendapatan kategori di periode ini.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Progress Bar: Payment Methods --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 lg:col-span-1">
            <h3 class="text-base font-bold text-gray-800 mb-6">Metode Pembayaran</h3>
            <div class="space-y-5">
                @forelse($byPayment as $pay)
                @php
                    // Helper to get method label
                    $methodNames = [
                        'cash' => 'Tunai (Cash)',
                        'qris' => 'QRIS'
                    ];
                    $methodColors = [
                        'cash' => 'bg-emerald-500',
                        'qris' => 'bg-indigo-500'
                    ];
                    $count = $pay->count;
                    $percent = $summary['revenue'] > 0 ? round(($pay->revenue / $summary['revenue']) * 100) : 0;
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-700 uppercase">{{ $methodNames[$pay->method] ?? $pay->method }}</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-gray-100 text-gray-500">{{ $count }}x</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900">Rp {{ number_format($pay->revenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="{{ $methodColors[$pay->method] ?? 'bg-gray-500' }} h-2 rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 text-right">{{ $percent }}% keseluruhan</p>
                </div>
                @empty
                <div class="py-8 text-center text-gray-400">
                    <p class="text-sm">Belum ada transaksi pembayaran terverifikasi.</p>
                </div>
                @endforelse
            </div>
        </div>
        
        {{-- Top Produk --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden lg:col-span-1">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-800">Top Produk Terjual</h3>
            </div>
            <div class="p-0">
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Omset</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($topProducts->take(6) as $index => $prod)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $index < 3 ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 line-clamp-1 truncate w-32" title="{{ $prod->product_name }}">{{ $prod->product_name }}</p>
                                        <p class="text-xs text-gray-400">{{ $prod->category_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="text-sm text-gray-600 font-medium">{{ $prod->total_qty }}</span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($prod->revenue, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-gray-400 text-sm">
                                Tidak ada produk terjual di periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
