<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Urutan status yang valid — tidak boleh mundur
    private const STATUS_FLOW = [
        'pending' => 0,
        'confirmed' => 1,
        'in_progress' => 2,
        'ready' => 3,
        'completed' => 4,
        'cancelled' => 99, // bisa dari status manapun selama belum completed
    ];

    public function index(Request $request)
    {
        $orders = Order::with(['payment'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->order_type, fn($q) => $q->where('order_type', $request->order_type))
            ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date))
            ->when($request->search, fn($q) => $q->where(function ($q) use ($request) {
            $q->where('order_code', 'like', "%{$request->search}%")
                ->orWhere('customer_name', 'like', "%{$request->search}%")
                ->orWhere('customer_phone', 'like', "%{$request->search}%");
        }
        ))
            ->latest()
            ->paginate($request->input('per_page', 10))->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'payment.verifiedBy']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,in_progress,ready,completed,cancelled',
            'cancel_reason' => 'nullable|string|max:500',
        ]);

        $newStatus = $request->status;
        $currentStatus = $order->status;

        // ✅ Guard: order yang sudah selesai/dibatalkan tidak bisa diubah
        if ($order->isFinished()) {
            return back()->with('error', 'Order yang sudah selesai atau dibatalkan tidak dapat diubah statusnya.');
        }

        // ✅ Guard: status tidak boleh mundur (kecuali cancelled)
        if (
        $newStatus !== 'cancelled' &&
        self::STATUS_FLOW[$newStatus] < self::STATUS_FLOW[$currentStatus]
        ) {
            return back()->with('error', "Status tidak bisa mundur dari '{$order->status_label}'.");
        }

        $data = ['status' => $newStatus];

        match ($newStatus) {
                'confirmed' => $data['confirmed_at'] = now(),
                'completed' => $data['completed_at'] = now(),
                'cancelled' => $data['cancelled_at'] = now(),
                default => null,
            };

        if ($newStatus === 'cancelled') {
            $data['cancel_reason'] = $request->cancel_reason;
        }

        $order->update($data);

        // ✅ Broadcast hanya jika event sudah ada (graceful fallback)
        $this->broadcastStatusUpdate($order->fresh());

        return back()->with('success', 'Status order berhasil diperbarui menjadi: ' . $order->fresh()->status_label);
    }

    public function verifyPayment(Order $order)
    {
        if (!$order->payment) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        if ($order->payment->status === 'verified') {
            return back()->with('error', 'Pembayaran ini sudah diverifikasi sebelumnya.');
        }

        $order->payment->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        // Auto konfirmasi order jika masih pending
        if ($order->status === 'pending') {
            $order->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
            $this->broadcastStatusUpdate($order->fresh());
        }

        // ✅ Tetap broadcast status pembayaran lunas meskipun status order tidak berubah
        $this->broadcastStatusUpdate($order->fresh());

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function rejectPayment(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        if (!$order->payment) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $order->payment->update([
            'status' => 'rejected',
            'reject_reason' => $request->reason ?? 'Bukti pembayaran tidak valid.',
        ]);

        // ✅ Broadcast agar user tahu pembayarannya ditolak (realtime)
        $this->broadcastStatusUpdate($order->fresh());

        return back()->with('success', 'Pembayaran ditolak. Customer perlu upload ulang bukti pembayaran.');
    }

    // ✅ Graceful broadcast — tidak crash jika Event belum dibuat
    private function broadcastStatusUpdate(Order $order): void
    {
        if (class_exists(\App\Events\OrderStatusUpdated::class)) {
            broadcast(new \App\Events\OrderStatusUpdated($order));
        }
    }
}