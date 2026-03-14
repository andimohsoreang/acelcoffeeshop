<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    public function index()
    {
        // 1. Ambil 5 Produk dengan Rating Tertinggi (Top Rated) beserta Total Terjual
        $topRatedProducts = Product::withCount('orderItems')
            ->orderBy('rating_avg', 'desc')
            ->orderBy('rating_count', 'desc') // Jika avg sama, prioritaskan yg reviewnya banyak
            ->take(5)
            ->get();

        // 2. Ambil 5 Produk Baru (Newcomers - Manual)
        // Difilter berdasarkan is_newcomer = true & diurutkan berdasarkan update produk supaya bisa diganti.
        $newComers = Product::where('is_newcomer', true)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.showcases.index', compact('topRatedProducts', 'newComers'));
    }
}
