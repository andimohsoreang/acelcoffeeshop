<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil 3 Produk dengan Rating Tertinggi (Top Rated) beserta Total Terjual (order_items count)
        $topRatedProducts = Product::withCount('orderItems')
            ->orderBy('rating_avg', 'desc')
            ->orderBy('rating_count', 'desc') // Jika avg sama, prioritaskan yg reviewnya banyak
            ->take(3)
            ->get();

        // 2. Ambil 4 Produk Rilisan Terbaru (New Comers)
        $newComers = Product::with('category')
            ->latest()
            ->take(4)
            ->get();

        // 3. Main Data Table
        $perPage = $request->input('per_page', 10);
        $products = Product::with('category')
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->status === 'available', fn($q) => $q->where('is_available', true))
            ->when($request->status === 'unavailable', fn($q) => $q->where('is_available', false))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories', 'topRatedProducts', 'newComers'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'nullable',
            'is_featured' => 'nullable',
            'is_newcomer' => 'nullable',
        ]);

        // ✅ Slug tidak perlu di-set manual — sudah di-generate otomatis di boot() model
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_available' => $request->boolean('is_available', true),
            'is_featured' => $request->boolean('is_featured', false),
            'is_newcomer' => $request->boolean('is_newcomer', false),
        ]);

        if ($request->hasFile('images')) {
            $imagePath = null;
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                
                if ($index === 0) {
                    $imagePath = $path; // Gunakan file pertama sebagai thumbnail
                }
                
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
            
            // Simpan thumbnail backward compatibility ke master product 
            if ($imagePath) {
                $product->update(['image' => $imagePath]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        // ✅ Fix: 'approvedReviews' relasi tidak ada di model.
        // Gunakan eager load dengan scope approved() sebagai gantinya.
        $product->load([
            'category',
            'images',
            'reviews' => fn($q) => $q->approved()->latest(),
        ]);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'nullable',
            'is_featured' => 'nullable',
            'is_newcomer' => 'nullable',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('images')) {
            // Hapus fisik gambar lama dari Storage List
            $filesToDelete = $product->images->pluck('image_path')->toArray();
            if ($product->image && !in_array($product->image, $filesToDelete)) {
                $filesToDelete[] = $product->image;
            }
            if (count($filesToDelete) > 0) {
                Storage::disk('public')->delete($filesToDelete);
            }
            
            // Putuskan / hapus relasi dari database
            $product->images()->delete();

            // Upload rentetan gambar baru dengan rapi
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                
                if ($index === 0) {
                    $imagePath = $path; // Ambil jalan pertama sebagai thumbnail fallback
                }

                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        // ✅ Slug tidak perlu di-set manual — sudah di-update otomatis di boot() model (isDirty check)
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'is_available' => $request->boolean('is_available'),
            'is_featured' => $request->boolean('is_featured'),
            'is_newcomer' => $request->boolean('is_newcomer'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // ✅ Guard: cegah hapus produk yang masih punya order aktif
        $hasActiveOrders = $product->orderItems()
            ->whereHas('order', fn($q) => $q->whereNotIn('status', ['completed', 'cancelled']))
            ->exists();

        if ($hasActiveOrders) {
            return back()->with('error', 'Produk tidak bisa dihapus karena masih ada order aktif yang menggunakan produk ini.');
        }

        // ✅ Hapus tuntas foto-foto bawaan untuk efisiensi Space Server
        $filesToDelete = $product->images->pluck('image_path')->toArray();
        if ($product->image && !in_array($product->image, $filesToDelete)) {
            $filesToDelete[] = $product->image;
        }
        if (count($filesToDelete) > 0) {
            Storage::disk('public')->delete($filesToDelete);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    // Toggle ketersediaan produk
    public function toggle(Product $product)
    {
        $product->update([
            'is_available' => !$product->is_available
        ]);

        return back()->with('success', 'Status ketersediaan produk berhasil diubah.');
    }

    /**
     * Delete a single targeted product image.
     */
    public function destroyImage(Product $product, $imageId)
    {
        $image = $product->images()->findOrFail($imageId);

        // Hapus fisik cover dari storage local bawaan kita
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $wasPrimary = $image->is_primary;
        $image->delete();

        // Oper relasi foto bila foto utama kehapus dan ada cadangan
        if ($wasPrimary && $product->images()->count() > 0) {
            $nextImage = $product->images()->first(); // Ambil first sisa di DB
            $nextImage->update(['is_primary' => true]);
            $product->update(['image' => $nextImage->image_path]); // Master Backup Update
        } 
        // Jika ludes tidak ada gambar
        elseif ($product->images()->count() === 0) {
            $product->update(['image' => null]);
            // Pastikan jika ada main image yang tersangkut lama (bawaan) ikut hapus file fisiknya
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                 Storage::disk('public')->delete($product->image);
            }
        }

        return back()->with('success', 'Satu Gambar berhasil dihapus dari stok galeri.');
    }
}