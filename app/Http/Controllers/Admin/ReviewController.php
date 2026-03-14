<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $reviews = Review::with(['product', 'order'])
            ->when($request->status === 'approved', fn($q) => $q->approved())
            ->when($request->status === 'pending', fn($q) => $q->pending())
            ->when($request->rating, fn($q) => $q->where('rating', $request->rating))
            ->when($request->search, function($q) use ($request) {
                // Bisa mencari pakai nama customer atau nama produk
                $q->where('customer_name', 'like', "%{$request->search}%")
                  ->orWhereHas('product', fn($prod) => $prod->where('name', 'like', "%{$request->search}%"));
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        // Guard: jangan proses ulang yang sudah approved
        if ($review->is_approved) {
            return back()->with('error', 'Review ini sudah disetujui sebelumnya.');
        }

        $review->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        $review->product->updateRatingCache();

        return back()->with('success', 'Review berhasil disetujui dan ditampilkan.');
    }

    public function reject(Review $review)
    {
        $review->update([
            'is_approved' => false,
            'approved_at' => null,
        ]);

        $review->product->updateRatingCache();

        return back()->with('success', 'Review berhasil ditolak.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        // Update rating cache pada produk
        if ($review->product) {
            $review->product->updateRatingCache();
        }

        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Review berhasil dihapus.');
    }
}