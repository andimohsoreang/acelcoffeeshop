<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $categories = Category::withCount('products')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->status === 'active', fn($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn($q) => $q->where('is_active', false))
            ->orderBy('sort_order')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    // Tidak dipakai di blade (pakai modal), tapi tetap ada untuk resource route
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'icon'        => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        Category::create([
            'name'        => $request->name,
            'icon'        => $request->icon,
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => true,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Tidak dipakai di blade (pakai modal), tapi tetap ada untuk resource route
    public function show(Category $category)
    {
        $category->loadCount('products');
        return view('admin.categories.show', compact('category'));
    }

    // Tidak dipakai di blade (pakai modal), tapi tetap ada untuk resource route
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'icon'        => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable',
        ]);

        $category->update([
            'name'        => $request->name,
            'icon'        => $request->icon,
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
            // ✅ boolean() handle hidden input "0" + checkbox "1" dengan benar
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        $category->delete();

        // ✅ redirect ke index bukan back() agar konsisten setelah delete dari modal
        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}