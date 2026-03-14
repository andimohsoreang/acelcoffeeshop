<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Tampilkan antarmuka Filter Laporan Penjualan
     */
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        // Ambil preview data
        $orders = Order::with('payment')
            ->whereIn('status', ['completed', 'ready'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->get();

        $totalRevenue = $orders->sum(fn($o) => $o->payment && $o->payment->status === 'verified' ? $o->payment->amount : 0);
        
        return view('admin.reports.index', compact('orders', 'startDate', 'endDate', 'totalRevenue'));
    }

    /**
     * Export laporan ke format Excel
     */
    public function exportExcel(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        $fileName = 'laporan_penjualan_' . $startDate . '_sd_' . $endDate . '.xlsx';
        
        return Excel::download(new SalesExport($startDate, $endDate), $fileName);
    }

    /**
     * Export laporan ke format PDF
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        $orders = Order::with('payment')
            ->whereIn('status', ['completed', 'ready'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->oldest()
            ->get();

        $totalRevenue = $orders->sum(fn($o) => $o->payment && $o->payment->status === 'verified' ? $o->payment->amount : 0);

        $pdf = Pdf::loadView('admin.reports.pdf', compact('orders', 'startDate', 'endDate', 'totalRevenue'));
        
        // Atur ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'landscape');

        // Render PDF (Download)
        $fileName = 'laporan_penjualan_' . $startDate . '_sd_' . $endDate . '.pdf';
        return $pdf->download($fileName);
    }
}
