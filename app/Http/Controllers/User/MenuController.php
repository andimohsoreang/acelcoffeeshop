<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->get();

        $products = Product::with('category')
            ->available()
            ->when($request->category, function ($q) use ($request) {
            $q->whereHas('category', fn($q) => $q->where('slug', $request->category));
        })
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(12);

        $selectedCategory = $request->category ?? 'semua';

        return view('user.menu.index', compact('categories', 'products', 'selectedCategory'));
    }

    public function show(string $slug)
    {
        // ✅ Fix: pakai firstOrFail() agar otomatis 404 jika tidak ada,
        // lalu load relasi terpisah agar lebih bersih
        $product = Product::where('slug', $slug)->firstOrFail();

        $product->load([
            'category',
            'reviews' => fn($q) => $q->approved()->latest(),
        ]);

        // Produk related dari kategori yang sama
        $relatedProducts = Product::with('category')
            ->available()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('user.menu.show', compact('product', 'relatedProducts'));
    }
}