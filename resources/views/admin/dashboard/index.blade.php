<x-layouts.admin>
    <x-slot:title>Dashboard Cerdas</x-slot:title>
    <x-slot:subtitle>Ringkasan performa bisnis — {{ now()->isoFormat('dddd, D MMMM Y') }}</x-slot:subtitle>

    {{-- Script ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- ============================================================
    ACTIONABLE ALERTS (Peringatan Tindakan Cepat)
    ============================================================ --}}
    @if($alerts['pending_reviews'] > 0 || $alerts['unverified_payments'] > 0)
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($alerts['unverified_payments'] > 0)
                <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-100 rounded-2xl p-4 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 animate-pulse">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-red-900">Pembayaran Menunggu Verifikasi</h3>
                            <p class="text-xs text-red-700 mt-0.5">Ada <strong>{{ $alerts['unverified_payments'] }} pesanan</strong> yang pembayarannya perlu dicek/diproses kasir.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-colors whitespace-nowrap shadow-sm">
                        Cek Sekarang
                    </a>
                </div>
            @endif

            @if($alerts['pending_reviews'] > 0)
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-4 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-blue-900">Ulasan Pelanggan Baru</h3>
                            <p class="text-xs text-blue-700 mt-0.5">Ada <strong>{{ $alerts['pending_reviews'] }} ulasan</strong> baru yang menunggu persetujuan Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-colors whitespace-nowrap shadow-sm">
                        Tinjau Ulasan
                    </a>
                </div>
            @endif
        </div>
    @endif

    {{-- ============================================================
    TIMEFRAME FILTER HEADER
    ============================================================ --}}
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
        <ul class="flex w-full overflow-x-auto hide-scroll p-1 gap-1">
            @php
                $ranges = [
                    'today' => 'Hari Ini',
                    'week' => 'Minggu Ini',
                    'month' => 'Bulan Ini',
                    'year' => 'Tahun Ini'
                ];
            @endphp
            @foreach($ranges as $key => $label)
                <li class="flex-1 sm:flex-none">
                    <a href="{{ route('admin.dashboard', ['range' => $key]) }}"
                       class="block text-center px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap
                       {{ $range === $key ? 'bg-slate-800 text-white shadow-md scale-100' : 'text-slate-500 hover:bg-slate-100 scale-95 hover:scale-100' }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- TEST NOTIFICATION BUTTON --}}
        <div class="mt-4 sm:mt-0 sm:ml-4 flex-shrink-0" x-data="testNotification()">
            <button @click="fireTest" :disabled="loading" 
                    class="px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-indigo-500/30 transition-all flex items-center gap-2"
                    :class="loading ? 'opacity-75 cursor-not-allowed' : ''">
                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span x-text="loading ? 'Mengirim...' : 'Test Notif Reverb'"></span>
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        function testNotification() {
            return {
                loading: false,
                async fireTest() {
                    this.loading = true;
                    try {
                        // Pastikan csrf token tersedia
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        const response = await fetch('{{ route('admin.test-notification') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            if (window.showToast) window.showToast('Terkirim!', data.message, 'success');
                            console.log('Test event dispatched successfully.');
                        } else {
                            if (window.showToast) window.showToast('Gagal', data.message || 'Error occurred', 'error');
                        }
                    } catch (err) {
                        console.error('Error firing test:', err);
                        if (window.showToast) window.showToast('Error', 'Gagal mengirim request', 'error');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
    @endpush

    {{-- ============================================================
    STATS CARDS
    ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        {{-- Total Order --}}
        <div class="bg-white rounded-[20px] p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:shadow-lg transition-all flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full blur-xl group-hover:bg-blue-100 transition-colors z-0"></div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0 text-white shadow-blue-500/30 shadow-lg z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <div class="z-10">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Order</p>
                <p class="text-lg font-black text-slate-800 tracking-tight">{{ number_format($stats['total_orders']) }}</p>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="bg-white rounded-[20px] p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:shadow-lg transition-all flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-xl group-hover:bg-emerald-100 transition-colors z-0"></div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center flex-shrink-0 text-white shadow-emerald-500/30 shadow-lg z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="z-10 min-w-0">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pendapatan Bersih</p>
                <p class="text-base font-black text-slate-800 tracking-tight">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-[20px] p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:shadow-lg transition-all flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full blur-xl group-hover:bg-amber-100 transition-colors z-0"></div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 flex items-center justify-center flex-shrink-0 text-white shadow-amber-500/30 shadow-lg z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="z-10">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pesanan Tunda</p>
                <p class="text-lg font-black text-amber-500 tracking-tight">{{ number_format($stats['pending_orders']) }}</p>
            </div>
        </div>

        {{-- Completed --}}
        <div class="bg-white rounded-[20px] p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:shadow-lg transition-all flex items-center gap-4 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-50 rounded-full blur-xl group-hover:bg-slate-100 transition-colors z-0"></div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center flex-shrink-0 text-white shadow-slate-500/30 shadow-lg z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="z-10">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pesanan Selesai</p>
                <p class="text-lg font-black text-slate-800 tracking-tight">{{ number_format($stats['completed_orders']) }}</p>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- ============================================================
        APEXCHARTS REVENUE
        ============================================================ --}}
        <div class="lg:col-span-2 bg-white rounded-[24px] p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 flex flex-col">
            <div class="mb-4">
                <h2 class="text-lg font-black text-slate-800">Tren Pendapatan</h2>
                <p class="text-xs text-slate-400 font-medium mt-1">
                    Visualisasi penjualan bersih (verified) untuk: {{ isset($ranges[$range]) ? $ranges[$range] : 'Hari Ini' }}
                </p>
            </div>
            <div class="flex-1 w-full min-h-[300px]" id="revenueChart"></div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var options = {
                    series: [{
                        name: 'Pendapatan',
                        data: @json($chartData['series'])
                    }],
                    chart: {
                        type: 'area',
                        height: '100%',
                        fontFamily: 'inherit',
                        toolbar: { show: false },
                        zoom: { enabled: false }
                    },
                    colors: ['#f59e0b'],
                    fill: {
                        type: 'gradient',
                        gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] }
                    },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3 },
                    xaxis: {
                        categories: @json($chartData['labels']),
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        labels: { style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 600 } }
                    },
                    yaxis: {
                        labels: {
                            style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 600 },
                            formatter: function (value) { return 'Rp ' + (value / 1000).toFixed(0) + 'k'; }
                        }
                    },
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4, yaxis: { lines: { show: true } } },
                    tooltip: {
                        theme: 'light',
                        y: { formatter: function (val) { return "Rp " + new Intl.NumberFormat('id-ID').format(val); } }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
                chart.render();
            });
        </script>

        {{-- ============================================================
        TOP PRODUCTS & PAYMENT breakdown
        ============================================================ --}}
        <div class="space-y-6 flex flex-col">

            {{-- Top Products --}}
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 flex-1">
                <h2 class="text-sm font-black text-slate-800 mb-5 uppercase tracking-widest flex items-center gap-2">
                    <span class="text-lg">🏆</span> Produk Terpopuler
                </h2>
                
                @php $maxQty = $topProducts->max('total_qty') ?: 1; @endphp
                <div class="space-y-4">
                    @forelse($topProducts as $i => $product)
                        <div class="relative pt-1">
                            <div class="flex items-center justify-between mb-1.5 relative z-10">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-lg {{ $i === 0 ? 'bg-amber-100 text-amber-700' : ($i === 1 ? 'bg-slate-100 text-slate-700' : 'bg-orange-50 text-orange-700') }} flex flex-shrink-0 items-center justify-center text-[10px] font-black shadow-sm">
                                        #{{ $i + 1 }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-700 truncate max-w-[140px]" title="{{ $product['product_name'] }}">{{ $product['product_name'] }}</span>
                                </div>
                                <span class="text-[11px] font-black text-slate-500 bg-slate-50 px-2 py-0.5 rounded-md">{{ $product['total_qty'] }} <span class="text-[9px] text-slate-400 font-semibold">terjual</span></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-1.5 rounded-full" style="width: {{ ($product['total_qty'] / $maxQty) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center p-4 text-center">
                            <span class="text-3xl mb-2 grayscale opacity-50">🛒</span>
                            <p class="text-xs text-slate-400 font-medium">Belum ada penjualan produk.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Payment Methods --}}
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100">
                <h2 class="text-sm font-black text-slate-800 mb-5 uppercase tracking-widest flex items-center gap-2">
                    <span class="text-lg">💳</span> Metode Pembayaran
                </h2>
                
                @php $maxPm = $paymentMethods->max('count') ?: 1; @endphp
                <div class="space-y-3">
                    @forelse($paymentMethods as $pm)
                        <div class="group">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $pm['label'] }}</span>
                                <span class="text-[10px] font-bold text-slate-500">{{ $pm['count'] }} TRx</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1 overflow-hidden">
                                <div class="bg-blue-500 h-1 rounded-full group-hover:bg-blue-600 transition-colors" style="width: {{ ($pm['count'] / $maxPm) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center italic py-2">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- ============================================================
    RECENT ORDERS TABLE
    ============================================================ --}}
    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 overflow-hidden mt-8">
        <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-slate-50/50">
            <div>
                <h2 class="text-base font-black text-slate-800">Order Terkini</h2>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Transaksi masuk paling baru pada {{ isset($ranges[$range]) ? $ranges[$range] : 'Hari Ini' }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                Lihat Semua
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white">
                        <th class="py-4 pl-6 pr-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Info Pesanan</th>
                        <th class="py-4 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Customer</th>
                        <th class="py-4 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Total</th>
                        <th class="py-4 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Status</th>
                        <th class="py-4 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Pembayaran</th>
                    </tr>
                </thead>
                <tbody id="orders-tbody" class="divide-y divide-slate-50">
                    @forelse($recentOrders as $order)
                    <tr data-order-id="{{ $order->id }}" class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-3 pl-6 pr-4 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 font-black flex items-center justify-center text-sm border border-amber-100 shadow-sm">
                                    {{ $order->queue_number }}
                                </div>
                                <div>
                                    <p class="font-mono text-[13px] font-bold text-slate-700">#{{ $order->order_code }}</p>
                                    <p class="text-[10px] font-medium text-slate-400 mt-0.5">{{ $order->created_at->format('H:i, d M Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 align-middle">
                            <p class="text-[13px] font-bold text-slate-800 line-clamp-1">{{ $order->customer_name }}</p>
                            <span class="inline-flex mt-0.5 items-center px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 text-[9px] font-bold uppercase tracking-widest">
                                {{ $order->order_type === 'dine_in' ? 'Dine In' : ($order->order_type === 'takeaway' ? 'Takeaway' : 'Delivery') }}
                            </span>
                        </td>
                        <td class="py-3 px-4 align-middle text-right">
                            <p class="text-[13px] font-black text-slate-800">{{ $order->formatted_total }}</p>
                        </td>
                        <td class="py-3 px-4 align-middle text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'confirmed' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'in_progress' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                    'ready' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'completed' => 'bg-green-100 text-green-700 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                ];
                                $stColor = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $stColor }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="py-3 px-4 align-middle text-center">
                            @if($order->payment)
                                @php
                                    $payColor = [
                                        'pending' => 'bg-yellow-50 text-yellow-600',
                                        'verified' => 'bg-green-50 text-green-600',
                                        'failed' => 'bg-red-50 text-red-600',
                                    ][$order->payment->status] ?? 'bg-slate-50 text-slate-600';
                                @endphp
                                <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold uppercase {{ $payColor }}">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                            @else
                                <span class="inline-block w-4 h-0.5 bg-slate-300 rounded-full"></span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-3 opacity-30 grayscale">🧾</span>
                                <p class="text-sm font-bold text-slate-500">Belum Ada Transaksi</p>
                                <p class="text-xs font-medium text-slate-400 max-w-xs mx-auto mt-1">Order yang masuk pada periode ini akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.admin>