<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $range = (string) $request->query('range', 'today'); // Default: hari ini

        // ============================================================
        // Helper scope based on range
        // ============================================================
        $applyTimeRange = function ($query) use ($range) {
            $now = now();
            return match ($range) {
                'today' => $query->whereDate('created_at', $now->toDateString()),
                'week'  => $query->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]),
                'month' => $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year),
                'year'  => $query->whereYear('created_at', $now->year),
                default => $query->whereDate('created_at', $now->toDateString()),
            };
        };

        // ============================================================
        // Stats
        // ============================================================
        $stats = [
            'total_orders' => Order::where($applyTimeRange)->count(),
            'revenue' => Payment::whereHas('order', $applyTimeRange)
                ->where('status', 'verified')
                ->sum('amount'),
            'pending_orders' => Order::where($applyTimeRange)->byStatus('pending')->count(),
            'completed_orders' => Order::where($applyTimeRange)->byStatus('completed')->count(),
        ];

        // ============================================================
        // Actionable Alerts (Peringatan Penting)
        // ============================================================
        $alerts = [
            'pending_reviews' => \App\Models\Review::pending()->count(),
            'unverified_payments' => Payment::where('status', 'pending')
                ->whereHas('order', fn($query) => $query->where('status', '!=', 'cancelled'))
                ->count(),
        ];

        // ============================================================
        // 10 order terbaru pada rentang waktu ini
        // ============================================================
        $recentOrders = Order::with(['payment'])
            ->where($applyTimeRange)
            ->latest()
            ->take(10)
            ->get();

        // ============================================================
        // Chart Data (Revenue) — Optimized with Single Query & Group By
        // ============================================================
        $chartData = [
            'labels' => [],
            'series' => [],
        ];

        if ($range === 'today') {
            // Data per jam (Bagi 2 jam sekali)
            $results = Payment::whereHas('order', fn($q) => $q->whereDate('created_at', now()->toDateString()))
                ->where('status', 'verified')
                ->selectRaw('HOUR(created_at) as hour, SUM(amount) as total')
                ->groupBy('hour')
                ->pluck('total', 'hour')
                ->toArray();

            for ($i = 0; $i < 24; $i += 2) {
                $chartData['labels'][] = sprintf('%02d:00', $i);
                $total = 0;
                for ($j = $i; $j < $i + 2; $j++) {
                    $total += $results[$j] ?? 0;
                }
                $chartData['series'][] = (float)$total;
            }
        } elseif ($range === 'week') {
            // Data per hari (Senin-Minggu)
            $start = now()->startOfWeek();
            $results = Payment::whereHas('order', fn($q) => $q->whereBetween('created_at', [$start, now()->endOfWeek()]))
                ->where('status', 'verified')
                ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
                ->groupBy('date')
                ->pluck('total', 'date')
                ->toArray();

            for ($i = 0; $i < 7; $i++) {
                $date = $start->copy()->addDays($i);
                $chartData['labels'][] = $date->isoFormat('ddd');
                $chartData['series'][] = (float)($results[$date->toDateString()] ?? 0);
            }
        } elseif ($range === 'month') {
            // Data per minggu-ish (Bagi jadi 4 minggu)
            $start = now()->startOfMonth();
            for ($i = 1; $i <= 4; $i++) {
                $chartData['labels'][] = "Week $i";
                $end = $i == 4 ? now()->endOfMonth() : $start->copy()->addDays(7);
                $sum = Payment::whereHas('order', fn($q) => $q->whereBetween('created_at', [$start, $end]))
                    ->where('status', 'verified')
                    ->sum('amount');
                $chartData['series'][] = (float)$sum;
                $start = $end->copy()->addSecond();
            }
            // Note: Month masih pakai loop 4x karena range mingguannya dinamis, 
            // tapi sudah cukup efisien dibanding loop harian.
        } elseif ($range === 'year') {
            // Data per bulan (Jan-Des)
            $results = Payment::whereHas('order', fn($q) => $q->whereYear('created_at', now()->year))
                ->where('status', 'verified')
                ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            for ($i = 1; $i <= 12; $i++) {
                $date = now()->month($i);
                $chartData['labels'][] = $date->isoFormat('MMM');
                $chartData['series'][] = (float)($results[$i] ?? 0);
            }
        }

        // ============================================================
        // Top 5 produk terlaris
        // ============================================================
        $topProducts = OrderItem::selectRaw('
                product_name,
                SUM(quantity) as total_qty,
                SUM(subtotal) as total_revenue
            ')
            ->whereHas('order', fn($q) => $q->where($applyTimeRange)->whereIn('status', ['completed', 'ready']))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // ============================================================
        // Breakdown metode pembayaran
        // ============================================================
        $paymentMethods = Payment::selectRaw('method, COUNT(*) as count')
            ->whereHas('order', $applyTimeRange)
            ->groupBy('method')
            ->get()
            ->map(fn($p) => [
                'method' => $p->method,
                'count' => $p->count,
                'label' => match ($p->method) {
                    'cash' => 'Tunai',
                    'qris' => 'QRIS',
                    default => ucfirst($p->method),
                },
            ]);

        $pendingOrdersCount = Order::byStatus('pending')->count(); // Tetap Global untuk navbar/sidebar

        $ranges = [
            'today' => 'Hari Ini',
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
        ];

        return view('admin.dashboard.index', compact(
            'stats',
            'recentOrders',
            'chartData',
            'topProducts',
            'paymentMethods',
            'pendingOrdersCount',
            'range',
            'ranges',
            'alerts'
        ));
    }

    public function testNotification(\Illuminate\Http\Request $request)
    {
        // Temukan order acak/terbaru untuk dijadikan test payload
        $order = Order::with('items')->latest()->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Belum ada order untuk di-test']);
        }

        // Tembak event Reverb (seolah-olah ada order baru)
        event(new \App\Events\OrderPlaced($order));

        return response()->json(['success' => true, 'message' => 'Event OrderPlaced berhasil dikirim ke Reverb!']);
    }
}