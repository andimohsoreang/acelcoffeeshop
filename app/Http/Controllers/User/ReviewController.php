<?php

// ============================================================
// FILE: app/Http/Controllers/User/ReviewController.php
// ============================================================

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['product', 'order'])
            ->approved()
            ->latest('approved_at')
            ->paginate(15);

        return view('user.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reviews' => 'required|array',
            'reviews.*.product_id' => 'required|exists:products,id',
            'reviews.*.rating' => 'required|integer|min:1|max:5',
            'reviews.*.comment' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Pastikan order sudah selesai
        if ($order->status !== 'completed') {
            return back()->with('error', 'Review hanya bisa diberikan setelah pesanan selesai.');
        }

        // Simpan semua review valid
        $savedCount = 0;

        foreach ($request->reviews as $reviewData) {
            // Cek apakah produk ini ada di order
            $orderItem = $order->items()->where('product_id', $reviewData['product_id'])->first();
            if (!$orderItem) {
                continue;
            }

            // Cek apakah sudah pernah review produk ini di order yang sama
            $existing = Review::where('order_id', $request->order_id)
                ->where('product_id', $reviewData['product_id'])
                ->first();

            if ($existing) {
                continue;
            }

            Review::create([
                'order_id' => $request->order_id,
                'product_id' => $reviewData['product_id'],
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'rating' => $reviewData['rating'] ?? 5,
                'comment' => $reviewData['comment'] ?? null,
                'is_approved' => false, // perlu approval admin dulu
            ]);
            
            $savedCount++;
        }

        if ($savedCount > 0) {
            return back()->with('success', 'Terima kasih! Review kamu berhasil dikirim (menunggu persetujuan admin).');
        }

        return back()->with('error', 'Tidak ada review baru yang berhasil disimpan.');
    }
}