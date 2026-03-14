<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Halaman order sukses
    public function success(string $orderCode)
    {
        $order = Order::with(['items', 'payment'])
            ->where('order_code', $orderCode)
            ->firstOrFail();

        return view('user.order.success', compact('order'));
    }

    // Halaman order gagal
    public function failed(Request $request)
    {
        $errorMessage = session('error', 'Terjadi kesalahan saat memproses pesanan.');
        $failedCart = session('failed_cart', []);
        $whatsappAdmin = Setting::get('whatsapp_admin', '');

        return view('user.order.failed', compact('errorMessage', 'failedCart', 'whatsappAdmin'));
    }

    // Riwayat order — cari berdasarkan no HP
    public function index(Request $request)
    {
        if (!$request->phone) {
            return view('user.order.index', ['orders' => collect(), 'searched' => false]);
        }

        // ✅ Sanitasi input phone sebelum query
        $phone = trim(preg_replace('/[^0-9+\-\s]/', '', $request->phone));

        if (empty($phone)) {
            return view('user.order.index', ['orders' => collect(), 'searched' => false]);
        }

        $orders = Order::with(['items', 'payment'])
            ->where('customer_phone', $phone)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return view('user.order.index', [
            'orders' => $orders,
            'searched' => true,
            'phone' => $phone,
        ]);
    }

    // Detail order — tracking status real-time
    public function show(string $orderCode)
    {
        $order = Order::with(['items.product', 'payment'])
            ->where('order_code', $orderCode)
            ->firstOrFail();

        return view('user.order.show', compact('order'));
    }
}