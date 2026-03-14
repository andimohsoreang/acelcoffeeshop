<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - {{ setting('shop_name', 'Kopi Nusantara') }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; color: #1e293b; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #64748b; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px 10px; text-align: left; }
        th { background-color: #f8fafc; color: #0f172a; font-weight: bold; text-transform: uppercase; font-size: 11px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background-color: #f1f5f9; }
        .status-badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .bg-green { background-color: #dcfce7; color: #166534; }
        .bg-yellow { background-color: #fef9c3; color: #854d0e; }
        .bg-red { background-color: #fee2e2; color: #991b1b; }
        .bg-gray { background-color: #f1f5f9; color: #475569; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Penjualan {{ setting('shop_name', 'Kopi Nusantara') }}</h1>
        @if(setting('shop_address'))
            <p style="font-size: 11px; margin-top: 5px;">{{ setting('shop_address') }}</p>
        @endif
        <p>Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No.</th>
                <th width="15%">Kode Pesanan</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Pelanggan</th>
                <th width="10%">Tipe</th>
                <th width="15%" class="text-center">Pembayaran</th>
                <th width="20%" class="text-right">Total Bersih (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $i => $order)
                @php
                    $paymentMethod = $order->payment ? ucfirst($order->payment->method) : '-';
                    $paymentStatus = $order->payment ? strtolower($order->payment->status) : 'unknown';
                    
                    $statusClass = 'bg-gray';
                    if($paymentStatus === 'verified') $statusClass = 'bg-green';
                    elseif($paymentStatus === 'pending') $statusClass = 'bg-yellow';
                    elseif($paymentStatus === 'failed') $statusClass = 'bg-red';

                    $amount = ($paymentStatus === 'verified') ? $order->payment->amount : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td><strong>#{{ $order->order_code }}</strong></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->order_type === 'dine_in' ? 'Dine In' : ($order->order_type === 'takeaway' ? 'Takeaway' : 'Delivery') }}</td>
                    <td class="text-center">
                        <div>{{ $paymentMethod }}</div>
                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($paymentStatus) }}</span>
                    </td>
                    <td class="text-right">{{ number_format($amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        @if($orders->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right" style="font-size: 14px; padding-top: 15px;">TOTAL PENDAPATAN BERSIH :</td>
                <td class="text-right" style="font-size: 14px; padding-top: 15px; color: #166534;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

</body>
</html>
