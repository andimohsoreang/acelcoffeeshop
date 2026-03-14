<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function query()
    {
        return Order::query()->with(['payment'])
            ->whereIn('status', ['completed', 'ready'])
            ->whereDate('created_at', '>=', $this->start)
            ->whereDate('created_at', '<=', $this->end)
            ->oldest();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN PENJUALAN ' . strtoupper(setting('shop_name', 'KOPI NUSANTARA'))],
            ['Periode: ' . $this->start . ' s/d ' . $this->end],
            [''], // Empty row for spacing
            [
                'No.',
                'Kode Pesanan',
                'Tanggal Transaksi',
                'Nama Pelanggan',
                'Tipe Pesanan',
                'Metode Pembayaran',
                'Status Pembayaran',
                'Total Bersih (Rp)',
            ]
        ];
    }

    public function map($order): array
    {
        static $number = 0;
        $number++;

        $paymentMethod = $order->payment ? ucfirst($order->payment->method) : '-';
        $paymentStatus = $order->payment ? ucfirst($order->payment->status) : '-';
        $totalAmount = $order->payment && $order->payment->status === 'verified' ? $order->payment->amount : 0;

        return [
            $number,
            $order->order_code,
            $order->created_at->format('d/m/Y H:i'),
            $order->customer_name,
            $order->order_type === 'dine_in' ? 'Dine In' : ($order->order_type === 'takeaway' ? 'Takeaway' : 'Delivery'),
            $paymentMethod,
            $paymentStatus,
            $totalAmount,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling the Header and Titles
        return [
            1    => ['font' => ['bold' => true, 'size' => 16]],
            2    => ['font' => ['italic' => true, 'size' => 12]],
            4    => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1E293B']]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Kode Pesanan
            'C' => 20,  // Tanggal Transaksi
            'D' => 25,  // Nama Pelanggan
            'E' => 15,  // Tipe Pesanan
            'F' => 20,  // Metode Pembayaran
            'G' => 20,  // Status Pembayaran
            'H' => 20,  // Total Bersih
        ];
    }
}
