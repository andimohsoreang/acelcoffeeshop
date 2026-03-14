<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->period ?? 'today';

        [$startDate, $endDate] = match ($period) {
                'today' => [today()->toDateString(), today()->toDateString()],
                'week' => [now()->subDays(6)->toDateString(), today()->toDateString()],
                'month' => [now()->startOfMonth()->toDateString(), today()->toDateString()],
                'custom' => [
                $request->start_date ?? today()->toDateString(),
                $request->end_date ?? today()->toDateString(),
            ],
                default => [today()->toDateString(), today()->toDateString()],
            };

        // ✅ Fix: pakai Carbon object agar kompatibel semua DB driver
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Label range
        $dateRangeLabel = $startDate === $endDate
            ?Carbon::parse($startDate)->isoFormat('D MMMM Y')
            : Carbon::parse($startDate)->isoFormat('D MMM') . ' — ' . Carbon::parse($endDate)->isoFormat('D MMM Y');

        // Summary
        $summary = [
            'revenue' => Payment::whereHas('order', fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->where('status', 'verified')
            ->sum('amount'),

            'total_orders' => Order::whereBetween('created_at', [$start, $end])->count(),

            'completed_orders' => Order::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->count(),

            'avg_order' => Order::whereBetween('created_at', [$start, $end])
            ->whereIn('status', ['completed', 'ready'])
            ->avg('total_amount') ?? 0,
        ];

        // Revenue per kategori
        $byCategory = DB::table('order_items as oi')
            ->join('products as p', 'oi.product_id', '=', 'p.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('orders as o', 'oi.order_id', '=', 'o.id')
            ->whereBetween('o.created_at', [$start, $end])
            ->whereIn('o.status', ['completed', 'ready'])
            ->selectRaw('c.name as category_name, c.icon, SUM(oi.quantity) as total_qty, SUM(oi.subtotal) as revenue')
            ->groupBy('c.id', 'c.name', 'c.icon')
            ->orderByDesc('revenue')
            ->get();

        $totalCatRevenue = $byCategory->sum('revenue') ?: 1;
        $byCategory = $byCategory->map(fn($c) => (object)array_merge(
        (array)$c,
        ['percentage' => round(($c->revenue / $totalCatRevenue) * 100)]
        ));

        // Revenue per metode pembayaran
        $byPayment = Payment::selectRaw('method, COUNT(*) as count, SUM(amount) as revenue')
            ->where('status', 'verified')
            ->whereHas('order', fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->groupBy('method')
            ->get();

        // Top produk
        $topProducts = DB::table('order_items as oi')
            ->join('products as p', 'oi.product_id', '=', 'p.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('orders as o', 'oi.order_id', '=', 'o.id')
            ->whereBetween('o.created_at', [$start, $end])
            ->whereIn('o.status', ['completed', 'ready'])
            ->selectRaw('oi.product_name, c.name as category_name, SUM(oi.quantity) as total_qty, SUM(oi.subtotal) as revenue')
            ->groupBy('oi.product_name', 'c.name')
            ->orderByDesc('revenue')
            ->get();

        $totalProdRevenue = $topProducts->sum('revenue') ?: 1;
        $topProducts = $topProducts->map(fn($p) => (object)array_merge(
        (array)$p,
        ['percentage' => round(($p->revenue / $totalProdRevenue) * 100)]
        ));

        return view('admin.finance.index', compact(
            'period', 'startDate', 'endDate', 'dateRangeLabel',
            'summary', 'byCategory', 'byPayment', 'topProducts'
        ));
    }
}